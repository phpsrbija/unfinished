<?php
declare(strict_types = 1);
namespace Menu\Service;

use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
use Menu\Mapper\MenuMapper;
use Menu\Filter\MenuFilter;
use Std\FilterException;
use Category\Service\CategoryService;
use Page\Service\PageService;

class MenuService
{
    private $menuMapper;
    private $menuFilter;
    private $categoryService;
    private $pageService;

    /**
     * We store menu items in DB as flat structure,
     * but we need nested(tree) structure to show in the menu.
     *
     * @param  array $flatArray Array from DB
     * @return array            Return same array with tree structure
     */
    private function unflattenArray(array $flatArray)
    {
        $flatArray = array_reverse($flatArray);
        $refs = [];
        $result = [];

        while (count($flatArray) > 0) {
            for ($i = count($flatArray) - 1; $i >= 0; $i--) {
                if (!isset($flatArray[$i]['children'])) {
                    $flatArray[$i]['children'] = [];
                }

                if (!$flatArray[$i]["parent_id"]) {
                    $result[$flatArray[$i]["menu_id"]] = $flatArray[$i];
                    $refs[$flatArray[$i]["menu_id"]] = &$result[$flatArray[$i]["menu_id"]];
                    unset($flatArray[$i]);
                    $flatArray = array_values($flatArray);
                } elseif ($flatArray[$i]["parent_id"] != 0) {
                    if (array_key_exists($flatArray[$i]["parent_id"], $refs)) {
                        $o = $flatArray[$i];
                        $refs[$flatArray[$i]["menu_id"]] = $o;
                        $refs[$flatArray[$i]["parent_id"]]["children"][] = &$refs[$flatArray[$i]["menu_id"]];
                        unset($flatArray[$i]);
                        $flatArray = array_values($flatArray);
                    }
                }
            }
        }

        return $result;
    }

    public function __construct(
        MenuMapper $menuMapper,
        MenuFilter $menuFilter,
        CategoryService $categoryService,
        PageService $pageService
    ) {
        $this->menuMapper = $menuMapper;
        $this->menuFilter = $menuFilter;
        $this->categoryService = $categoryService;
        $this->pageService = $pageService;
    }

    public function getNestedAll($isActive = null, $filter = [])
    {
        $items = $this->menuMapper->selectAll($isActive, $filter)->toArray();

        return $this->unflattenArray($items);
    }

    public function get($id)
    {
        return $this->menuMapper->get($id);
    }

    public function addMenuItem($data)
    {
        $data = $this->filterMenuItem($data);

        $data['menu_id'] = Uuid::uuid1()->toString();
        $data['menu_uuid'] = (new MysqlUuid($data['menu_id']))->toFormat(new Binary);

        return $this->menuMapper->insertMenuItem($data);
    }

    public function updateMenuItem($data, $id)
    {
        $data = $this->filterMenuItem($data);

        return $this->menuMapper->updateMenuItem($data, $id);
    }

    public function delete($id)
    {
        $children = $this->menuMapper->select(['parent_id' => $id]);

        if ($children->count()) {
            throw new \Exception('This Menu Item has child items', 400);
        }

        return $this->menuMapper->delete(['menu_id' => $id]);
    }

    public function getForSelect()
    {
        return $this->menuMapper->forSelect();
    }

    public function updateMenuOrder($menuOrder)
    {
        if (!$menuOrder) {
            return true;
        }

        try {
            $this->menuMapper->getAdapter()->getDriver()->getConnection()->beginTransaction();
            $orderNo = 1;
            $this->updateLevel($menuOrder, $orderNo, null);
            $this->menuMapper->getAdapter()->getDriver()->getConnection()->commit();
        } catch (\Exception $e) {
            $this->menuMapper->getAdapter()->getDriver()->getConnection()->rollback();

            throw $e;
        }

        return true;
    }

    private function updateLevel($children, &$orderNo, $parentId = null)
    {
        foreach ($children as $v) {
            if (isset($v->children)) {
                $this->menuMapper->update(['order_no' => $orderNo++, 'parent_id' => $parentId], ['menu_id' => $v->id]);
                $this->updateLevel($v->children, $orderNo, $v->id);
            } else {
                $this->menuMapper->update(['order_no' => $orderNo++, 'parent_id' => $parentId], ['menu_id' => $v->id]);
            }
        }
    }

    private function filterMenuItem($data)
    {
        $filter = $this->menuFilter->getInputFilter()->setData($data);

        if (!$filter->isValid()) {
            throw new FilterException($filter->getMessages());
        }

        if (count(array_filter([$data['page_id'], $data['category_id'], $data['href']])) > 1) {
            throw new \Exception('You need to set only one link. Post, Category or Href.');
        }

        $data = $filter->getValues();

        if ($data['page_id']) {
            $page = $this->pageService->getPage($data['page_id']);
            $data['page_uuid'] = $page->getPageUuid();
            $data['category_uuid'] = null;
        } elseif ($data['category_id']) {
            $category
                = $this->categoryService->getCategory($data['category_id']);
            $data['category_uuid'] = $category->category_uuid;
            $data['page_uuid'] = null;
        } else {
            $data['page_uuid'] = null;
            $data['category_uuid'] = null;
        }

        unset($data['page_id'], $data['category_id']);

        return $data;
    }
}
