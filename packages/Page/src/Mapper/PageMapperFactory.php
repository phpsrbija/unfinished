<?php

namespace Page\Mapper;

use Page\Entity\Page;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Hydrator\ArraySerializable;
use Zend\Db\ResultSet\HydratingResultSet;

class PageMapperFactory
{
    public function __invoke(ContainerInterface $container): PageMapper
    {
        $adapter   = $container->get(Adapter::class);
        $resultSet = new HydratingResultSet(new ArraySerializable, new Page);

        return new PageMapper($adapter, $resultSet);
    }

}
