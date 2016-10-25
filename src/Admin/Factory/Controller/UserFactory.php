<?php

declare(strict_types = 1);

namespace Admin\Factory\Controller;

use Admin\Controller\UserController;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

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
     * @param ContainerInterface $container container
     * @return UserController
     */
    public function __invoke(ContainerInterface $container) : UserController
    {
        return new UserController(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
