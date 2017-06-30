<?php

declare(strict_types=1);

namespace Article\Factory\Controller;

use Article\Controller\VideoController;
use Article\Service\VideoService;
use Category\Service\CategoryService;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

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
