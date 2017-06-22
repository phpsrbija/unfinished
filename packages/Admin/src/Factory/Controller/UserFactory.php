<?php

declare(strict_types = 1);

namespace Admin\Factory\Controller;

use Admin\Controller\UserController;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Admin\Service\AdminUserService;
use Zend\Expressive\Router\RouterInterface;

/**
 * Class UserFactory.
 *
 * @package Admin\Factory\Controller
 */
final class UserFactory
{
    /**
     * Factory method for UserController.
     *
     * @param  ContainerInterface $container container
     * @return UserController
     */
    public function __invoke(ContainerInterface $container) : UserController
    {
        return new UserController(
            $container->get(TemplateRendererInterface::class),
            $container->get(RouterInterface::class),
            $container->get(AdminUserService::class),
            $container->get('session')
        );
    }
}
