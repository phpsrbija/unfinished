<?php

declare(strict_types = 1);

namespace Category\Factory\Controller;

use Category\Controller\IndexController;
use Category\Service\CategoryService;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class CategoryFactory.
 *
 * @package Category\Factory\Controller
 */
final class IndexFactory
{
    /**
     * Factory method for IndexFactory.
     *
     * @param  ContainerInterface $container container
     * @return IndexController
     */
    public function __invoke(ContainerInterface $container) : IndexController
    {
        return new IndexController(
            $container->get(TemplateRendererInterface::class),
            $container->get(RouterInterface::class),
            $container->get(CategoryService::class)
        );
    }
}
