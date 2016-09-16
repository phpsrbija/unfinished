<?php

namespace Admin\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Router\RouterInterface;

class AuthFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuthController(
            $container->get(RouterInterface::class),
            $container->get(TemplateRendererInterface::class),
            $container->get('session')
        );
    }
}
