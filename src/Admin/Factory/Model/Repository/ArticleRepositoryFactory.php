<?php

namespace Admin\Factory\Model\Repository;

use Admin\Model\Storage\ArticleStorageInterface;
use Admin\Model\Repository\ArticleRepository;
use Interop\Container\ContainerInterface;

class ArticleRepositoryFactory
{
    /**
     * @param ContainerInterface $container
     * @return ArticleRepository
     */
    public function __invoke(ContainerInterface $container)
    {
        return new ArticleRepository(
            $container->get(ArticleStorageInterface::class),
            new \DateTime()
        );
    }
}
