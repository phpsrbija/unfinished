<?php
declare(strict_types = 1);

namespace Admin\Factory\Controller;

use Admin\Controller\DiscussionController;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Core\Service\DiscussionService;
use Core\Service\TagService;
use Zend\Expressive\Router\RouterInterface;

class DiscussionFactory
{
    public function __invoke(ContainerInterface $container) : DiscussionController
    {
        return new DiscussionController(
            $container->get(TemplateRendererInterface::class),
            $container->get(RouterInterface::class),
            $container->get(DiscussionService::class),
            $container->get('session'),
            $container->get(TagService::class)
        );
    }
}
