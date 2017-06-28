<?php
declare(strict_types = 1);
namespace Menu\Factory;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;

class FilterFactory
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) : \Menu\Filter\MenuFilter {
        return new $requestedName($container->get(Adapter::class));
    }
}
