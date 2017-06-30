<?php

declare(strict_types=1);

namespace Page\Mapper;

use Interop\Container\ContainerInterface;
use Page\Entity\Page;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Hydrator\ArraySerializable;

class PageMapperFactory
{
    public function __invoke(ContainerInterface $container): PageMapper
    {
        $adapter = $container->get(Adapter::class);
        $resultSet = new HydratingResultSet(new ArraySerializable(), new Page());

        return new PageMapper($adapter, $resultSet);
    }
}
