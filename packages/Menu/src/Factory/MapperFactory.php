<?php
declare(strict_types = 1);
namespace Menu\Factory;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;

class MapperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $instance = new $requestedName;
        $instance->setDbAdapter($container->get(Adapter::class));
        $instance->initialize();

        return $instance;
    }

}
