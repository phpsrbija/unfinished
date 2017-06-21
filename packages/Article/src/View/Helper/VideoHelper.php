<?php

namespace Article\View\Helper;

use Article\Service\VideoService;
use Zend\View\Helper\AbstractHelper;

class VideoHelper extends AbstractHelper
{
    private $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function __invoke()
    {
        return $this;
    }

    public function getLatest($limit = 4)
    {
        return $this->videoService->fetchLatest($limit);
    }

}
