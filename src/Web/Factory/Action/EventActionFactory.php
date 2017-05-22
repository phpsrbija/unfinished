<?php

declare(strict_types=1);

namespace Web\Factory\Action;

use Article\Service\EventService;
use Category\Service\CategoryService;
use GuzzleHttp\ClientInterface;
use Interop\Container\ContainerInterface;
use Web\Action\EventAction;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class EventActionFactory.
 *
 * @package Web\Factory\Action
 */
class EventActionFactory
{
    /**
     * @param ContainerInterface $container
     * @return EventAction
     */
    public function __invoke(ContainerInterface $container): EventAction
    {
        return new EventAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(EventService::class),
            $container->get(CategoryService::class),
            $container->get(ClientInterface::class)
        );
    }
}
