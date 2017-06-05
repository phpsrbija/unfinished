<?php
declare(strict_types=1);

namespace Article\Factory\Controller;

use Article\Controller\DiscussionController;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Article\Service\DiscussionService;
use Category\Service\CategoryService;
use Zend\Expressive\Router\RouterInterface;

class DiscussionFactory
{
    public function __invoke(ContainerInterface $container): DiscussionController
    {
        return new DiscussionController(
            $container->get(TemplateRendererInterface::class),
            $container->get(RouterInterface::class),
            $container->get(DiscussionService::class),
            $container->get('session'),
            $container->get(CategoryService::class)
        );
    }
}
