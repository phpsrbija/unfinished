<?php

namespace Admin\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;

class LogoutHandleFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new LogoutHandleAction(
            $container->get(RouterInterface::class),
            $container->get('session')
        );
    }
}
