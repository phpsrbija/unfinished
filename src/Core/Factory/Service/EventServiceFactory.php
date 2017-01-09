<?php

namespace Core\Factory\Service;

use Core\Mapper\ArticleMapper;
use Core\Service\EventService;
use Core\Mapper\ArticleEventsMapper;
use Core\Filter\ArticleFilter;
use Core\Filter\EventFilter;
use Interop\Container\ContainerInterface;

class EventServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return EventService
     */
    public function __invoke(ContainerInterface $container)
    {
        return new EventService(
            $container->get(ArticleMapper::class),
            $container->get(ArticleEventsMapper::class),
            $container->get(ArticleFilter::class),
            $container->get(EventFilter::class)
        );
    }
}
