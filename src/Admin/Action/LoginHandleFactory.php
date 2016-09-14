<?php

namespace Admin\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;

class LoginHandleFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new LoginHandleAction(
            $container->get(RouterInterface::class),
            $container->get('session')
        );
    }
}
