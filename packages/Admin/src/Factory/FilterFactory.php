<?php
declare(strict_types = 1);
namespace Admin\Factory;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;

/**
 * Class FilterFactory
 *
 * @package Admin\Factory
 */
class FilterFactory
{
    /**
     * @param ContainerInterface $container     container
     * @param string             $requestedName requested name
     * @param array|null         $options       options
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName(
            $container->get(Adapter::class)
        );
    }
}
