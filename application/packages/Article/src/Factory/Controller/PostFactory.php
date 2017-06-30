<?php

declare(strict_types=1);

namespace Article\Factory\Controller;

use Article\Controller\PostController;
use Article\Service\PostService;
use Category\Service\CategoryService;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class PostFactory
{
    public function __invoke(ContainerInterface $container) : PostController
    {
        return new PostController(
            $container->get(TemplateRendererInterface::class),
            $container->get(RouterInterface::class),
            $container->get(PostService::class),
            $container->get('session'),
            $container->get(CategoryService::class)
        );
    }
}
