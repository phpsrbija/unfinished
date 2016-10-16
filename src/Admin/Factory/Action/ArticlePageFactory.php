<?php
declare(strict_types = 1);

namespace Admin\Factory\Action;

use Admin\Action\ArticlePageAction;
use Admin\Validator\ArticleValidator;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Admin\Model\Repository\ArticleRepositoryInterface;

class ArticlePageFactory
{
    public function __invoke(ContainerInterface $container) : ArticlePageAction
    {
        return new ArticlePageAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(ArticleRepositoryInterface::class),
            new ArticleValidator()
        );
    }
}
