<?php
declare(strict_types = 1);

namespace Admin\Factory\Controller;

use Admin\Controller\PostController;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Core\Service\Article\PostService;
use Core\Service\TagService;
use Zend\Expressive\Router\RouterInterface;

class PostFactory
{
    public function __invoke(ContainerInterface $container) : PostController
    {
        return new PostController(
            $container->get(TemplateRendererInterface::class),
            $container->get(PostService::class),
            $container->get('session'),
            $container->get(RouterInterface::class),
            $container->get(TagService::class)
        );
    }
}
