<?php

namespace Admin\Factory\Model\Repository;

use Admin\Mapper\ArticleMapper;
use Admin\Model\Repository\ArticleRepository;
use Interop\Container\ContainerInterface;
use \Admin\Validator\ArticleValidator as Validator;

class ArticleRepositoryFactory
{
    /**
     * @param ContainerInterface $container
     * @return ArticleRepository
     */
    public function __invoke(ContainerInterface $container)
    {
        return new ArticleRepository(
            $container->get(ArticleMapper::class),
            new \DateTime(),
            new Validator()
        );
    }
}
