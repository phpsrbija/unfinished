<?php
declare(strict_types = 1);

namespace Admin\Factory\Controller;

use Admin\Controller\ArticleController;
use Admin\Validator\ArticleValidator;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Admin\Model\Repository\ArticleRepositoryInterface;
use Zend\Expressive\Router\RouterInterface;

class ArticleFactory
{
    public function __invoke(ContainerInterface $container) : ArticleController
    {
        return new ArticleController(
            $container->get(TemplateRendererInterface::class),
            $container->get(ArticleRepositoryInterface::class),
            new ArticleValidator(),
            $container->get('session'),
            $container->get(RouterInterface::class)
        );
    }
}