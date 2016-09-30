<?php

namespace Web\Factory\Middleware;

use Web\Middleware\Layout;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;

class LayoutFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Layout(
            $container->get(RouterInterface::class),
            $container->get('config')
        );
    }
}
