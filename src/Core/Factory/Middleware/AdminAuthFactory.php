<?php
declare(strict_types = 1);
namespace Core\Factory\Middleware;

use Core\Middleware\AdminAuth;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;

/**
 * Class AdminAuthFactory.
 *
 * @package Core\Factory\Middleware
 */
class AdminAuthFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param ContainerInterface $container container
     *
     * @return AdminAuth
     */
    public function __invoke(ContainerInterface $container) : AdminAuth
    {
        return new AdminAuth(
            $container->get(RouterInterface::class),
            $container->get('session')
        );
    }
}
