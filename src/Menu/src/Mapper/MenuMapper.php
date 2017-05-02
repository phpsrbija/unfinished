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
            //->join('articles', 'articles.id = menu.article_id', ['url_slug'], 'left')
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
        $this->update($data, ['id' => $id]);

        return $id;
    }

    public function forSelect()
    {
        $select = $this->getSql()->select()
            ->columns(['id', 'title', 'is_active'])
            ->order(['is_active' => 'desc']);

        return $this->selectWith($select);
    }
}