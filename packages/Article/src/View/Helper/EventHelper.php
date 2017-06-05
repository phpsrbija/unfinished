<?php

namespace Article\View\Helper;

use Article\Service\EventService;
use Zend\View\Helper\AbstractHelper;

class EventHelper extends AbstractHelper
{
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke()
    {
        return $this;
    }

    public function getLatest($limit = 4)
    {
        return $this->eventService->fetchLatest($limit);
    }

}