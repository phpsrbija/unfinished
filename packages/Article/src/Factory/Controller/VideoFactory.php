<?php

declare(strict_types = 1);

namespace Article\Factory\Controller;

use Article\Controller\VideoController;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Article\Service\VideoService;
use Category\Service\CategoryService;
use Zend\Expressive\Router\RouterInterface;

class VideoFactory
{
    public function __invoke(ContainerInterface $container) : VideoController
    {
        return new VideoController(
            $container->get(TemplateRendererInterface::class),
            $container->get(RouterInterface::class),
            $container->get(VideoService::class),
            $container->get('session'),
            $container->get(CategoryService::class)
        );
    }
}
