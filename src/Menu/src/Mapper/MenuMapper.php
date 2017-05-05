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

    public function selectAll()
    {
        $select = $this->getSql()->select()
            ->order(['order_no' => 'asc']);

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