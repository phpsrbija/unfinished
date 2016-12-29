<?php

namespace Core\Factory\Service;

use Core\Mapper\ArticleMapper;
use Core\Service\ArticleService;
use Interop\Container\ContainerInterface;

class ArticleServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return ArticleService
     */
    public function __invoke(ContainerInterface $container)
    {
        return new ArticleService(
            $container->get(ArticleMapper::class),
            new \DateTime()
        );
    }
}
