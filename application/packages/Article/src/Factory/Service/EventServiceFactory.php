<?php

declare(strict_types=1);

namespace Article\Factory\Service;

use Admin\Mapper\AdminUsersMapper;
use Article\Filter\ArticleFilter;
use Article\Filter\EventFilter;
use Article\Mapper\ArticleEventsMapper;
use Article\Mapper\ArticleMapper;
use Article\Service\EventService;
use Category\Mapper\CategoryMapper;
use Interop\Container\ContainerInterface;
use UploadHelper\Upload;

class EventServiceFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return EventService
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')['upload'];
        $upload = new Upload($config['public_path'], $config['non_public_path']);

        return new EventService(
            $container->get(ArticleMapper::class),
            $container->get(ArticleEventsMapper::class),
            $container->get(ArticleFilter::class),
            $container->get(EventFilter::class),
            $container->get(CategoryMapper::class),
            $upload,
            $container->get(AdminUsersMapper::class)
        );
    }
}
