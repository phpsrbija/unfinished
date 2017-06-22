<?php

namespace Menu\Factory;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;

class FilterFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName($container->get(Adapter::class));
    }

}
