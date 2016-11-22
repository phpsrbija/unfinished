<?php
declare(strict_types = 1);
namespace Web\Factory\Middleware;

use Web\Middleware\Layout;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;

/**
 * Class LayoutFactory.
 *
 * @package Web\Factory\Middleware
 */
class LayoutFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param ContainerInterface $container container
     *
     * @return Layout
     */
    public function __invoke(ContainerInterface $container) : Layout
    {
        return new Layout(
            $container->get(RouterInterface::class),
            $container->get('config')
        );
    }
}
