<?php

namespace Article\View\Helper;

use Interop\Container\ContainerInterface;
use Article\Service\PostService;

class PostHelperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PostHelper(
            $container->get(PostService::class)
        );
    }

}