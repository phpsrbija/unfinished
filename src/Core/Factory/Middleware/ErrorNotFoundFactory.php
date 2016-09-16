<?php

namespace Core\Factory\Middleware;

use Core\Middleware\ErrorNotFound;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ErrorNotFoundFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ErrorNotFound(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
