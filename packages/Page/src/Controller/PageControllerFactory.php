<?php

declare(strict_types=1);

namespace Page\Controller;

use Interop\Container\ContainerInterface;
use Page\Service\PageService;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

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
