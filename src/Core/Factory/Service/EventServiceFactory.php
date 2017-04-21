<?php

namespace Core\Factory\Service;

use UploadHelper\Upload;
use Core\Mapper\ArticleMapper;
use Core\Service\Article\EventService;
use Core\Mapper\ArticleEventsMapper;
use Core\Mapper\TagsMapper;
use Core\Filter\ArticleFilter;
use Core\Filter\EventFilter;
use Interop\Container\ContainerInterface;

class EventServiceFactory
{
    /**
     * @param ContainerInterface $container
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
            $container->get(TagsMapper::class),
            $upload
        );
    }
}
