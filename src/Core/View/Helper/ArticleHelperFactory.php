<?php

namespace Core\View\Helper;

use Interop\Container\ContainerInterface;
use Core\Service\Article\PostService;

class ArticleHelperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ArticleHelper(
            $container->get(PostService::class)
        );
    }

}