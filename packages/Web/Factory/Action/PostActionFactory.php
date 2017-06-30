<?php

declare(strict_types=1);

namespace Web\Factory\Action;

use Article\Service\PostService;
use Interop\Container\ContainerInterface;
use Web\Action\PostAction;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class PostActionFactory.
 */
class PostActionFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return PostAction
     */
    public function __invoke(ContainerInterface $container): PostAction
    {
        return new PostAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(PostService::class)
        );
    }
}
