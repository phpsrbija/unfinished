<?php

declare(strict_types=1);

namespace Web\Factory\Action;

use Article\Service\VideoService;
use Category\Service\CategoryService;
use Interop\Container\ContainerInterface;
use Web\Action\VideosAction;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class VideosActionFactory.
 *
 * @package Web\Factory\Action
 */
class VideosActionFactory
{
    /**
     * @param ContainerInterface $container
     * @return VideosAction
     */
    public function __invoke(ContainerInterface $container): VideosAction
    {
        return new VideosAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(VideoService::class),
            $container->get(CategoryService::class)
        );
    }
}
