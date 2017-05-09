<?php

namespace Menu\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;

class MenuMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    protected $table = 'menu';

    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function selectAll($isActive = null, $filter = [])
    {
        $select = $this->getSql()->select()
            ->join('category', 'menu.category_uuid = category.category_uuid', ['category_name' => 'name', 'category_slug' => 'slug'], 'left')
            ->join('articles', 'articles.article_uuid = menu.article_uuid', ['article_id', 'article_slug' => 'slug'], 'left')
            ->order(['order_no' => 'asc']);

        if($isActive !== null) {
            $select->where(['is_active' => $isActive]);
        }

        if($filter) {
            if(isset($filter['is_in_header'])) {
                $select->where(['is_in_header' => $filter['is_in_header']]);
            } elseif(isset($filter['is_in_footer'])) {
                $select->where(['is_in_footer' => $filter['is_in_footer']]);
            } elseif(isset($filter['is_in_side'])) {
                $select->where(['is_in_side' => $filter['is_in_side']]);
            }
        }

        return $this->selectWith($select);
    }

    public function insertMenuItem($data)
    {
        $this->insert($data);

        return $this->getLastInsertValue();
    }

    public function updateMenuItem($data, $id)
    {
        $this->update($data, ['menu_id' => $id]);

        return $id;
    }

    public function get($id)
    {
        $select = $this->getSql()->select()
            ->join('articles', 'articles.article_uuid = menu.article_uuid', ['article_id'], 'left')
            ->join('category', 'category.category_uuid = menu.category_uuid', ['category_id'], 'left')
            ->where(['menu_id' => $id]);

        return $this->selectWith($select)->current();
    }

    public function forSelect()
    {
        $select = $this->getSql()->select()
            ->columns(['menu_id', 'title', 'is_active'])
            ->order(['is_active' => 'desc']);

        return $this->selectWith($select);
    }
}