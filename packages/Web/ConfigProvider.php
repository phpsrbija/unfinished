<?php

namespace Web;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'templates' => [
                'map'   => [
                    'layout/web'         => 'templates/layout/web.phtml',
                    'article/pagination' => 'templates/partial/pagination.phtml',
                ],
                'paths' => [
                    'templates' => ['templates'],
                    'web'       => ['templates/web'],
                ],
            ],

            'dependencies' => [
                'factories' => [
                    Action\HomeAction::class   => Factory\Action\HomeActionFactory::class,
                    Action\PageAction::class   => Factory\Action\PageActionFactory::class,
                    Action\PostsAction::class  => Factory\Action\PostsActionFactory::class,
                    Action\PostAction::class   => Factory\Action\PostActionFactory::class,
                    Action\VideosAction::class => Factory\Action\VideosActionFactory::class,
                    Action\VideoAction::class  => Factory\Action\VideoActionFactory::class,
                    Action\EventsAction::class => Factory\Action\EventsActionFactory::class,
                    Action\EventAction::class  => Factory\Action\EventActionFactory::class,
                ],
            ],

            'routes' => [
                [
                    'name'       => 'home',
                    'path'       => '/',
                    'middleware' => Action\HomeAction::class,
                ],
                [
                    'name'       => 'page',
                    'path'       => '/:url_slug',
                    'middleware' => Action\PageAction::class,
                ],
                [
                    'name'       => 'category',
                    'path'       => '/{category}/',
                    'middleware' => [
                        Action\PostsAction::class,
                        Action\VideosAction::class,
                        Action\EventsAction::class,
                    ],
                ],
                [
                    'name'       => 'post',
                    'path'       => '/{segment_1}/{segment_2}',
                    'middleware' => [
                        Action\PostAction::class,
                        Action\VideoAction::class,
                        Action\EventAction::class,
                    ],
                ],
            ],
        ];
    }
}
