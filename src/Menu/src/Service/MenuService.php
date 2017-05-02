<?php

namespace Menu\Service;

use Menu\Mapper\MenuMapper;
use Menu\Filter\MenuFilter;
use Core\Exception\FilterException;

class MenuService
{
    private $menuMapper;
    private $menuFilter;

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

        while(count($flatArray) > 0){
            for($i = count($flatArray) - 1; $i >= 0; $i--){
                if(!isset($flatArray[$i]['children'])){
                    $flatArray[$i]['children'] = [];
                }

                if(!$flatArray[$i]["parent_id"]){
                    $result[$flatArray[$i]["id"]] = $flatArray[$i];
                    $refs[$flatArray[$i]["id"]]   = &$result[$flatArray[$i]["id"]];
                    unset($flatArray[$i]);
                    $flatArray = array_values($flatArray);
                }
                else if($flatArray[$i]["parent_id"] != 0){
                    if(array_key_exists($flatArray[$i]["parent_id"], $refs)){
                        $o                                               = $flatArray[$i];
                        $refs[$flatArray[$i]["id"]]                      = $o;
                        $refs[$flatArray[$i]["parent_id"]]["children"][] = &$refs[$flatArray[$i]["id"]];
                        unset($flatArray[$i]);
                        $flatArray = array_values($flatArray);
                    }
                }
            }
        }

        return $result;
    }

    public function __construct(MenuMapper $menuMapper, MenuFilter $menuFilter)
    {
        $this->menuMapper = $menuMapper;
        $this->menuFilter = $menuFilter;
    }

    public function getNestedAll()
    {
        $items = $this->menuMapper->selectAll()->toArray();

        return $this->unflattenArray($items);
    }

    public function get($id)
    {
        return $this->menuMapper->select(['id' => $id])->current();
    }

    public function save($data, $id = 0)
    {
        $filter = $this->menuFilter->getInputFilter()->setData($data);

        if(!$filter->isValid()){
            throw new FilterException($filter->getMessages());
        }

        $data = $filter->getValues();

        if($id){
            return $this->menuMapper->updateMenuItem($data, $id);
        }
        else{
            return $this->menuMapper->insertMenuItem($data);
        }
    }

    public function delete($id)
    {
        return $this->menuMapper->delete(['id' => $id]);
    }

    public function getForSelect()
    {
        return $this->menuMapper->forSelect();
    }

    public function updateMenuOrder($menuOrder)
    {
        if(!$menuOrder){
            return true;
        }

        $orderNo = 1;
        $this->updateLevel(null, $menuOrder, $orderNo);

        return true;
    }

    private function updateLevel($parentId = null, $children, &$orderNo)
    {
        foreach($children as $v){
            if(isset($v->children)){
                $this->menuMapper->update(['order_no' => $orderNo++, 'parent_id' => $parentId], ['id' => $v->id]);

                $this->updateLevel($v->id, $v->children, $orderNo);
            }
            else{
                $this->menuMapper->update(['order_no' => $orderNo++, 'parent_id' => $parentId], ['id' => $v->id]);
            }
        }
    }
}