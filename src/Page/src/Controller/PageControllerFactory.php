<?php

namespace Page\Controller;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Page\Service\PageService;
use Zend\Expressive\Router\RouterInterface;

class PageControllerFactory
{
    public function __invoke(ContainerInterface $container): PageController
    {
        return new PageController(
            $container->get(TemplateRendererInterface::class),
            $container->get(RouterInterface::class),
            $container->get(PageService::class)
        );
    }

}