<?php

namespace Article\Factory\View\Helper;

use Article\View\Helper\PostHelper;
use Article\Service\PostService;
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