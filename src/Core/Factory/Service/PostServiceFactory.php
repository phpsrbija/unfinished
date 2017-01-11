<?php

namespace Core\Factory\Service;

use Core\Mapper\ArticleMapper;
use Core\Mapper\ArticleTagsMapper;
use Core\Mapper\ArticlePostsMapper;
use Core\Mapper\TagsMapper;
use Core\Service\PostService;
use Core\Filter\ArticleFilter;
use Core\Filter\PostFilter;
use Interop\Container\ContainerInterface;

class PostServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return PostService
     */
    public function __invoke(ContainerInterface $container)
    {
        return new PostService(
            $container->get(ArticleMapper::class),
            $container->get(ArticlePostsMapper::class),
            $container->get(ArticleFilter::class),
            $container->get(PostFilter::class),
            $container->get(ArticleTagsMapper::class),
            $container->get(TagsMapper::class)
        );
    }
}
