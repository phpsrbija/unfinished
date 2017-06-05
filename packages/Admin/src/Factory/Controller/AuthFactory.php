<?php
declare(strict_types = 1);
namespace Admin\Factory\Controller;

use Admin\Controller\AuthController;
use Core\Service\AdminUserService;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Router\RouterInterface;

/**
 * Class AuthFactory.
 *
 * @package Admin\Factory\Controller
 */
final class AuthFactory
{
    /**
     * Factory method.
     *
     * @param ContainerInterface $container container
     *
     * @return AuthController
     */
    public function __invoke(ContainerInterface $container) : AuthController
    {
        return new AuthController(
            $container->get(RouterInterface::class),
            $container->get(TemplateRendererInterface::class),
            $container->get('session'),
            $container->get(AdminUserService::class)
        );
    }
}
