<?php

declare(strict_types = 1);

namespace Admin\Factory\Controller;

use Admin\Controller\PostController;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class PostFactory.
 *
 * @package Admin\Factory\Controller
 */
final class PostFactory
{
    /**
     * Factory method for PostController.
     *
     * @param  ContainerInterface $container container
     * @return PostController
     */
    public function __invoke(ContainerInterface $container) : PostController
    {
        return new PostController(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
