<?php

namespace Core\View\Helper;

use Interop\Container\ContainerInterface;
use Core\Service\Article\PostService;

class PostHelperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PostHelper(
            $container->get(PostService::class)
        );
    }

}