<?php
declare(strict_types=1);
namespace Menu\Factory\Controller;

use Menu\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Menu\Service\MenuService;
use Zend\Expressive\Router\RouterInterface;

/**
 * Class IndexControllerFactory.
 *
 * @package Menu\Factory\Controller
 */
final class IndexControllerFactory
{
    /**
     * Factory method for IndexController.
     *
     * @param  ContainerInterface $container container
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
