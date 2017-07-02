<?php

declare(strict_types=1);

namespace Menu\Factory\Controller;

use Interop\Container\ContainerInterface;
use Menu\Controller\IndexController;
use Menu\Service\MenuService;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class IndexControllerFactory.
 */
final class IndexControllerFactory
{
    /**
     * Factory method for IndexController.
     *
     * @param ContainerInterface $container container
     *
     * @return IndexController
     */
    public function __invoke(ContainerInterface $container) : IndexController
    {
        return new IndexController(
            $container->get(TemplateRendererInterface::class),
            $container->get(RouterInterface::class),
            $container->get(MenuService::class)
        );
    }
}
