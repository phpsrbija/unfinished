<?php

namespace Menu\Service;

use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
use Menu\Mapper\MenuMapper;
use Menu\Filter\MenuFilter;
use Core\Exception\FilterException;
use Category\Service\CategoryService;
use Core\Service\Article\PostService;

class MenuService
{
    private $menuMapper;
    private $menuFilter;
    private $categoryService;
    private $postService;

    /**
     * We store menu items in DB as flat structure,
     * but we need nested(tree) structure to show in the menu.
     *
     * @param array $flatArray Array from DB
     * @return array            Return same array with tree structure
     */
    private function unflattenArray(array $flatArray)
    {
        $flatArray = array_reverse($flatArray);
        $refs      = [];
        $result    = [];

        while(count($flatArray) > 0) {
            for($i = count($flatArray) - 1; $i >= 0; $i--) {
                if(!isset($flatArray[$i]['children'])) {
                    $flatArray[$i]['children'] = [];
                }

                if(!$flatArray[$i]["parent_id"]) {
                    $result[$flatArray[$i]["menu_id"]] = $flatArray[$i];
                    $refs[$flatArray[$i]["menu_id"]]   = &$result[$flatArray[$i]["menu_id"]];
                    unset($flatArray[$i]);
                    $flatArray = array_values($flatArray);
                } else if($flatArray[$i]["parent_id"] != 0) {
                    if(array_key_exists($flatArray[$i]["parent_id"], $refs)) {
                        $o                                               = $flatArray[$i];
                        $refs[$flatArray[$i]["menu_id"]]                 = $o;
                        $refs[$flatArray[$i]["parent_id"]]["children"][] = &$refs[$flatArray[$i]["menu_id"]];
                        unset($flatArray[$i]);
                        $flatArray = array_values($flatArray);
                    }
                }
            }
        }

        return $result;
    }

    public function __construct(MenuMapper $menuMapper, MenuFilter $menuFilter, CategoryService $categoryService, PostService $postService)
    {
        $this->menuMapper      = $menuMapper;
        $this->menuFilter      = $menuFilter;
        $this->categoryService = $categoryService;
        $this->postService     = $postService;
    }

    public function getNestedAll()
    {
        $items = $this->menuMapper->selectAll()->toArray();

        return $this->unflattenArray($items);
    }

    public function get($id)
    {
        return $this->menuMapper->get($id);
    }

    public function save($data, $id = 0)
    {
        $filter = $this->menuFilter->getInputFilter()->setData($data);

        if(!$filter->isValid()) {
            throw new FilterException($filter->getMessages());
        }

        $data = $filter->getValues();

        if($data['article_id']) {
            $article               = $this->postService->fetchSingleArticle($data['article_id']);
            $data['article_uuid']  = $article->article_uuid;
            $data['category_uuid'] = null;
            $data['href']          = null;
        } elseif($data['category_id']) {
            $category              = $this->categoryService->getCategory($data['category_id']);
            $data['category_uuid'] = $category->category_uuid;
            $data['article_uuid']  = null;
            $data['href']          = null;
        } elseif($data['href']) {
            $data['category_uuid'] = null;
            $data['article_uuid']  = null;
        }

        unset($data['article_id'], $data['category_id']);

        if($id) {
            return $this->menuMapper->updateMenuItem($data, $id);
        } else {
            $data['menu_id']   = Uuid::uuid1()->toString();
            $data['menu_uuid'] = (new MysqlUuid($data['menu_id']))->toFormat(new Binary);

            return $this->menuMapper->insertMenuItem($data);
        }
    }

    public function delete($id)
    {
        $children = $this->menuMapper->select(['parent_id' => $id]);

        if($children->count()) {
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
        if(!$menuOrder) {
            return true;
        }

        $orderNo = 1;
        $this->updateLevel(null, $menuOrder, $orderNo);

        return true;
    }

    private function updateLevel($parentId = null, $children, &$orderNo)
    {
        foreach($children as $v) {
            if(isset($v->children)) {
                $this->menuMapper->update(['order_no' => $orderNo++, 'parent_id' => $parentId], ['menu_id' => $v->id]);

                $this->updateLevel($v->id, $v->children, $orderNo);
            } else {
                $this->menuMapper->update(['order_no' => $orderNo++, 'parent_id' => $parentId], ['menu_id' => $v->id]);
            }
        }
    }
}