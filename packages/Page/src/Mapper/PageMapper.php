<?php

declare(strict_types=1);

namespace Page\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class PageMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    protected $table = 'page';

    public function setDbAdapter(Adapter $adapter)
    {
        throw new \Exception('Set DB adapter in constructor.', 400);
    }

    public function __construct(Adapter $adapter, HydratingResultSet $resultSet)
    {
        $this->resultSetPrototype = $resultSet;
        $this->adapter = $adapter;
        $this->initialize();
    }

    public function getPaginationSelect()
    {
        return $this->getSql()->select()->order(
            [
            'is_homepage' => 'desc',
            'created_at'  => 'desc',
            ]
        );
    }

    public function getActivePage($urlSlug)
    {
        return $this->select(['slug' => $urlSlug, 'is_active' => true]);
    }
}
