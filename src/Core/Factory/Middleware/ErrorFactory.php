<?php

namespace Core\Factory\Middleware;

use Core\Middleware\Error;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ErrorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Error(
            $container->get(TemplateRendererInterface::class)
        );
    }
}