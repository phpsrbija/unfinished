<?php

declare(strict_types=1);

namespace Article\Factory\View\Helper;

use Article\Service\VideoService;
use Article\View\Helper\VideoHelper;
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
