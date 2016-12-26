<?php

declare(strict_types = 1);

namespace Admin\Factory\Controller;

use Admin\Controller\TagController;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Core\Service\TagService;
use Zend\Expressive\Router\RouterInterface;

/**
 * Class TagFactory.
 *
 * @package Admin\Factory\Controller
 */
final class TagFactory
{
    /**
     * Factory method for TagController.
     *
     * @param  ContainerInterface $container container
     * @return TagController
     */
    public function __invoke(ContainerInterface $container) : TagController
    {
        return new TagController(
            $container->get(TemplateRendererInterface::class),
            $container->get(RouterInterface::class),
            $container->get(TagService::class)
        );
    }
}
