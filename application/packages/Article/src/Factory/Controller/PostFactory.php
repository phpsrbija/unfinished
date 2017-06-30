<?php

declare(strict_types = 1);

namespace Article\Factory\Controller;

use Article\Controller\PostController;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Article\Service\PostService;
use Category\Service\CategoryService;
use Zend\Expressive\Router\RouterInterface;

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
