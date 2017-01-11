<?php

namespace Core\Factory\Service;

use Core\Mapper\ArticleMapper;
use Core\Mapper\ArticleTagsMapper;
use Core\Mapper\TagsMapper;
use Core\Service\DiscussionService;
use Core\Mapper\ArticleDiscussionsMapper;
use Core\Filter\ArticleFilter;
use Core\Filter\DiscussionFilter;
use Interop\Container\ContainerInterface;

class DiscussionServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return DiscussionService
     */
    public function __invoke(ContainerInterface $container)
    {
        return new DiscussionService(
            $container->get(ArticleMapper::class),
            $container->get(ArticleDiscussionsMapper::class),
            $container->get(ArticleFilter::class),
            $container->get(DiscussionFilter::class),
            $container->get(ArticleTagsMapper::class),
            $container->get(TagsMapper::class)
        );
    }
}
