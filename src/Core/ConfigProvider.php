<?php

namespace Core;

use Zend\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'factories' => [
                    'session'                              => Factory\SessionFactory::class,

                    // Services
                    Service\AdminUserService::class        => Factory\Service\AdminUserServiceFactory::class,
                    Service\TagService::class              => Factory\Service\TagServiceFactory::class,
                    Service\Article\PostService::class     => Factory\Service\PostServiceFactory::class,
                    Service\DiscussionService::class       => Factory\Service\DiscussionServiceFactory::class,
                    Service\EventService::class            => Factory\Service\EventServiceFactory::class,
                    Service\VideoService::class            => Factory\Service\VideoServiceFactory::class,

                    // Mappers
                    Mapper\AdminUsersMapper::class         => Factory\MapperFactory::class,
                    Mapper\ArticleMapper::class            => Factory\MapperFactory::class,
                    Mapper\TagsMapper::class               => Factory\MapperFactory::class,
                    Mapper\ArticlePostsMapper::class       => Factory\MapperFactory::class,
                    Mapper\ArticleDiscussionsMapper::class => Factory\MapperFactory::class,
                    Mapper\ArticleTagsMapper::class        => Factory\MapperFactory::class,
                    Mapper\ArticleEventsMapper::class      => Factory\MapperFactory::class,
                    Mapper\ArticleVideosMapper::class      => Factory\MapperFactory::class,

                    // Filters
                    Filter\TagFilter::class                => InvokableFactory::class,
                    Filter\AdminUserFilter::class          => Factory\FilterFactory::class,
                    Filter\ArticleFilter::class            => InvokableFactory::class,
                    Filter\PostFilter::class               => InvokableFactory::class,
                    Filter\DiscussionFilter::class         => InvokableFactory::class,
                    Filter\EventFilter::class              => InvokableFactory::class,
                    Filter\VideoFilter::class              => InvokableFactory::class,

                    // Register custom Middlewares
                    Middleware\Error::class                => Factory\Middleware\ErrorFactory::class,
                    Middleware\ErrorNotFound::class        => Factory\Middleware\ErrorNotFoundFactory::class,
                    Middleware\AdminAuth::class            => Factory\Middleware\AdminAuthFactory::class,
                ],
            ],

            'middleware_pipeline' => [
                // execute this middlweare on every /admin[*] path
                'permission' => [
                    'middleware' => [Middleware\AdminAuth::class],
                    'priority'   => 100,
                    'path'       => '/admin'
                ],

                'error404' => [
                    'middleware' => [
                        Middleware\ErrorNotFound::class,
                        \Zend\Expressive\Middleware\NotFoundHandler::class
                    ],
                    'priority'   => -10,
                ],

                //'error' => [
                //    'middleware' => [Middleware\Error::class],
                //    'error'      => true,
                //    'priority'   => -1,
                //],
            ],
        ];
    }
}
