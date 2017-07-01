<?php

declare(strict_types=1);

namespace Web\Factory\Action;

use Article\Service\VideoService;
use Category\Service\CategoryService;
use Interop\Container\ContainerInterface;
use Web\Action\VideoAction;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class VideoActionFactory.
 */
class VideoActionFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return VideoAction
     */
    public function __invoke(ContainerInterface $container): VideoAction
    {
        return new VideoAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(VideoService::class),
            $container->get(CategoryService::class)
        );
    }
}
