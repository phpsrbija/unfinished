<?php

namespace Admin\Factory\Db;

use Admin\Model\Entity\ArticleEntity;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Hydrator\ArraySerializable;
use Admin\Db\ArticleTableGateway;

class ArticleTableGatewayFactory
{
    /**
     * @param ContainerInterface $container
     * @return ArticleTableGateway
     */
    public function __invoke(ContainerInterface $container)
    {
        $resultSetPrototype = new HydratingResultSet(
            new ArraySerializable(),
            new ArticleEntity()
        );

        return new ArticleTableGateway(
            $container->get(AdapterInterface::class),
            $resultSetPrototype
        );
    }
}
