<?php

namespace Admin\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Router\RouterInterface;

class LoginFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new LoginAction(
            $container->get(RouterInterface::class),
            $container->get(TemplateRendererInterface::class),
            $container->get('session')
        );
    }
}
