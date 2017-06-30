<?php

declare(strict_types=1);

namespace Web\Factory\Action;

use Article\Service\EventService;
use Category\Service\CategoryService;
use Interop\Container\ContainerInterface;
use Web\Action\EventsAction;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class EventsActionFactory.
 */
class EventsActionFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return EventsAction
     */
    public function __invoke(ContainerInterface $container): EventsAction
    {
        return new EventsAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(EventService::class),
            $container->get(CategoryService::class)
        );
    }
}
