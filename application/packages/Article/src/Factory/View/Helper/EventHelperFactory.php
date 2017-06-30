<?php
declare(strict_types = 1);
namespace Article\Factory\View\Helper;

use Article\View\Helper\EventHelper;
use Article\Service\EventService;
use Interop\Container\ContainerInterface;

class EventHelperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new EventHelper(
            $container->get(EventService::class)
        );
    }
}
