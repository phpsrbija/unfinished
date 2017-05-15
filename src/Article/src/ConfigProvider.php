<?php

namespace Article;

use Zend\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'templates' => [
                'paths' => [
                    'article' => [__DIR__ . '/../templates/article'],
                ],
            ],

            'dependencies' => [
                'factories' => [
                    // Controllers
                    Controller\PostController::class       => Factory\Controller\PostFactory::class,
                    Controller\DiscussionController::class => Factory\Controller\DiscussionFactory::class,
                    Controller\EventController::class      => Factory\Controller\EventFactory::class,
                    Controller\VideoController::class      => Factory\Controller\VideoFactory::class,

                    // Services
                    Service\PostService::class             => Factory\Service\PostServiceFactory::class,
                    Service\DiscussionService::class       => Factory\Service\DiscussionServiceFactory::class,
                    Service\EventService::class            => Factory\Service\EventServiceFactory::class,
                    Service\VideoService::class            => Factory\Service\VideoServiceFactory::class,

                    // Mappers
                    Mapper\ArticleMapper::class            => \Core\Factory\MapperFactory::class,
                    Mapper\ArticleCategoriesMapper::class  => \Core\Factory\MapperFactory::class,
                    Mapper\ArticlePostsMapper::class       => \Core\Factory\MapperFactory::class,
                    Mapper\ArticleDiscussionsMapper::class => \Core\Factory\MapperFactory::class,
                    Mapper\ArticleEventsMapper::class      => \Core\Factory\MapperFactory::class,
                    Mapper\ArticleVideosMapper::class      => \Core\Factory\MapperFactory::class,

                    // Filters
                    Filter\ArticleFilter::class            => InvokableFactory::class,
                    Filter\PostFilter::class               => InvokableFactory::class,
                    Filter\DiscussionFilter::class         => InvokableFactory::class,
                    Filter\EventFilter::class              => InvokableFactory::class,
                    Filter\VideoFilter::class              => InvokableFactory::class,
                ],
            ],

            'routes' => [
                [
                    'name'            => 'admin.posts',
                    'path'            => '/admin/posts',
                    'middleware'      => Controller\PostController::class,
                    'allowed_methods' => ['GET'],
                ],
                [
                    'name'            => 'admin.posts.action',
                    'path'            => '/admin/posts/:action/:id',
                    'middleware'      => Controller\PostController::class,
                    'allowed_methods' => ['GET', 'POST'],
                ],
                [
                    'name'            => 'admin.discussions',
                    'path'            => '/admin/discussions',
                    'middleware'      => Controller\DiscussionController::class,
                    'allowed_methods' => ['GET', 'POST']
                ],
                [
                    'name'            => 'admin.discussions.action',
                    'path'            => '/admin/discussions/:action/:id',
                    'middleware'      => Controller\DiscussionController::class,
                    'allowed_methods' => ['GET', 'POST']
                ],
                [
                    'name'            => 'admin.events',
                    'path'            => '/admin/events',
                    'middleware'      => Controller\EventController::class,
                    'allowed_methods' => ['GET', 'POST']
                ],
                [
                    'name'            => 'admin.events.action',
                    'path'            => '/admin/events/:action/:id',
                    'middleware'      => Controller\EventController::class,
                    'allowed_methods' => ['GET', 'POST']
                ],
                [
                    'name'            => 'admin.videos',
                    'path'            => '/admin/videos',
                    'middleware'      => Controller\VideoController::class,
                    'allowed_methods' => ['GET', 'POST']
                ],
                [
                    'name'            => 'admin.videos.action',
                    'path'            => '/admin/videos/:action/:id',
                    'middleware'      => Controller\VideoController::class,
                    'allowed_methods' => ['GET', 'POST']
                ]
            ],

            'view_helpers' => [
                'factories' => [
                    'post'  => Factory\View\Helper\PostHelperFactory::class,
                    'event' => Factory\View\Helper\EventHelperFactory::class,
                    'video' => Factory\View\Helper\VideoHelperFactory::class,
                ],
            ],

        ];
    }
}
