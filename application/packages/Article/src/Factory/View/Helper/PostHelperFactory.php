<?php

declare(strict_types=1);

namespace Article\Factory\View\Helper;

use Article\Service\PostService;
use Article\View\Helper\PostHelper;
use Interop\Container\ContainerInterface;

class PostHelperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PostHelper(
            $container->get(PostService::class)
        );
    }
}
