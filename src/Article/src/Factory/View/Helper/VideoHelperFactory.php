<?php

namespace Article\Factory\View\Helper;

use Article\View\Helper\VideoHelper;
use Article\Service\VideoService;
use Interop\Container\ContainerInterface;

class VideoHelperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new VideoHelper(
            $container->get(VideoService::class)
        );
    }

}