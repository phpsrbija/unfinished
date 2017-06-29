<?php

declare(strict_types=1);
namespace Web\Factory\Action;

use Article\Service\PostService;
use Category\Service\CategoryService;
use Interop\Container\ContainerInterface;
use Web\Action\PostsAction;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class CategoryActionFactory.
 *
 * @package Web\Factory\Action
 */
class PostsActionFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return PostsAction
     */
    public function __invoke(ContainerInterface $container): PostsAction
    {
        return new PostsAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(PostService::class),
            $container->get(CategoryService::class)
        );
    }
}
