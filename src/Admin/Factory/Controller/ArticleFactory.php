<?php
declare(strict_types = 1);

namespace Admin\Factory\Controller;

use Admin\Controller\ArticleController;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Core\Service\ArticleServiceInterface;
use Zend\Expressive\Router\RouterInterface;

class ArticleFactory
{
    public function __invoke(ContainerInterface $container) : ArticleController
    {
        return new ArticleController(
            $container->get(TemplateRendererInterface::class),
            $container->get(ArticleServiceInterface::class),
            $container->get('session'),
            $container->get(RouterInterface::class)
        );
    }
}
