<?php

declare(strict_types=1);

namespace Web\Factory\Action;

use Article\Service\PostService;
use Category\Service\CategoryService;
use Interop\Container\ContainerInterface;
use Web\Action\CategoryAction;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class CategoryActionFactory.
 *
 * @package Web\Factory\Action
 */
class CategoryActionFactory
{
    /**
     * @param ContainerInterface $container
     * @return CategoryAction
     */
    public function __invoke(ContainerInterface $container): CategoryAction
    {
        return new CategoryAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(PostService::class),
            $container->get(CategoryService::class)
        );
    }
}
