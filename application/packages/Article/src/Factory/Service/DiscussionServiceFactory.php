<?php

declare(strict_types=1);

namespace Article\Factory\Service;

use Admin\Mapper\AdminUsersMapper;
use Article\Filter\ArticleFilter;
use Article\Filter\DiscussionFilter;
use Article\Mapper\ArticleDiscussionsMapper;
use Article\Mapper\ArticleMapper;
use Article\Service\DiscussionService;
use Category\Mapper\CategoryMapper;
use Interop\Container\ContainerInterface;

class DiscussionServiceFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return DiscussionService
     */
    public function __invoke(ContainerInterface $container)
    {
        return new DiscussionService(
            $container->get(ArticleMapper::class),
            $container->get(ArticleDiscussionsMapper::class),
            $container->get(ArticleFilter::class),
            $container->get(DiscussionFilter::class),
            $container->get(CategoryMapper::class),
            $container->get(AdminUsersMapper::class)
        );
    }
}
