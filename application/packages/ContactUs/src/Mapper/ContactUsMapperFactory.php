<?php

namespace ContactUs\Mapper;

use Interop\Container\ContainerInterface;
use ContactUs\Entity\ContactUs;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Hydrator\ArraySerializable;

/**
 * Class ContactUsMapperFactory
 *
 * @package ContactUs\Mapper
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class ContactUsMapperFactory
{
    /**
     * @param  ContainerInterface $container
     *
     * @return ContactUsMapper
     */
    public function __invoke(ContainerInterface $container): ContactUsMapper
    {
        $adapter   = $container->get(Adapter::class);
        $resultSet = new HydratingResultSet(
            new ArraySerializable(), new ContactUs()
        );

        return new ContactUsMapper($adapter, $resultSet);
    }
}