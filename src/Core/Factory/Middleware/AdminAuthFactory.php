<?php

namespace Core\Factory\Middleware;

use Core\Middleware\AdminAuth;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;

class AdminAuthFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AdminAuth(
            $container->get(RouterInterface::class),
            $container->get('session')
        );
    }
}
