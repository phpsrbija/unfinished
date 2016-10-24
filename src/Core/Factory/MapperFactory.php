<?php
declare(strict_types = 1);
namespace Core\Factory;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;

/**
 * Class MapperFactory.
 *
 * @package Core\Factory
 */
class MapperFactory
{
    /**
     * @param ContainerInterface $container     container
     * @param string             $requestedName requested name
     * @param array|null         $options       options
     *
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $instance = new $requestedName;
        $instance->setDbAdapter($container->get(Adapter::class));
        $instance->initialize();

        return $instance;
    }
}
