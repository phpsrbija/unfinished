<?php

declare(strict_types=1);

namespace Article\Factory\Controller;

use Article\Controller\EventController;
use Article\Service\EventService;
use Category\Service\CategoryService;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class EventFactory
{
    public function __invoke(ContainerInterface $container) : EventController
    {
        return new EventController(
            $container->get(TemplateRendererInterface::class),
            $container->get(RouterInterface::class),
            $container->get(EventService::class),
            $container->get('session'),
            $container->get(CategoryService::class)
        );
    }
}
