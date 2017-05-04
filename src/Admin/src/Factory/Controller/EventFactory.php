<?php
declare(strict_types = 1);

namespace Admin\Factory\Controller;

use Admin\Controller\EventController;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Core\Service\EventService;
use Category\Service\CategoryService;
use Zend\Expressive\Router\RouterInterface;

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
