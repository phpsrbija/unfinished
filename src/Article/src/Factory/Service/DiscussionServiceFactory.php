<?php

namespace Article\Factory\Service;

use Article\Mapper\ArticleMapper;
use Category\Mapper\CategoryMapper;
use Article\Service\DiscussionService;
use Article\Mapper\ArticleDiscussionsMapper;
use Article\Filter\ArticleFilter;
use Article\Filter\DiscussionFilter;
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
            $container->get(CategoryMapper::class)
        );
    }
}
