<?php

namespace Web;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'templates' => [
                'map'   => [
                    'layout/legacy' => 'templates/layout/legacy.phtml',
                    'layout/web'    => 'templates/layout/web.phtml',
                ],
                'paths' => [
                    'templates' => ['templates'],
                    'web'       => ['templates/web'],
                    'legacy'    => ['templates/legacy'],
                ],
            ],

            'dependencies' => [
                'factories' => [
                    // Web
                    Action\HomeAction::class     => Factory\Action\HomeActionFactory::class,
                    Action\CategoryAction::class => Factory\Action\CategoryActionFactory::class,
                    Action\PostAction::class     => Factory\Action\PostActionFactory::class,

                    // Legacy
                    Legacy\SingleAction::class   => Factory\Legacy\SingleFactory::class,
                    Legacy\JoinAction::class     => Factory\Legacy\JoinFactory::class,
                    Legacy\AboutAction::class    => Factory\Legacy\AboutFactory::class,
                    Legacy\StatutAction::class   => Factory\Legacy\StatutFactory::class,
                    Legacy\ContactAction::class  => Factory\Legacy\ContactFactory::class,
                    Legacy\ContactAction::class  => Factory\Legacy\ContactFactory::class,
                    Legacy\ListAction::class     => Factory\Legacy\ListFactory::class,
                    Legacy\IndexAction::class    => Factory\Legacy\IndexFactory::class,
                ],
            ],

            'routes' => [
                // New
                [
                    'name'       => 'home',
                    'path'       => '/',
                    'middleware' => Action\HomeAction::class
                ],
                [
                    'name'       => 'category',
                    'path'       => '/:category/',
                    'middleware' => Action\CategoryAction::class
                ],
                [
                    'name'       => 'post',
                    'path'       => '/:segment_1[/:segment_2]',
                    'middleware' => Action\PostAction::class
                ],

                //[
                //    'name'       => 'post',
                //    'path'       => '/:category/:post',
                //    'middleware' => Action\CategoryAction::class
                //],

                // Legacy
                //[
                //    'name'       => 'single',
                //    'path'       => '/single/:slug/',
                //    'middleware' => Legacy\SingleAction::class,
                //],
                //[
                //    'name'       => 'legacy.join',
                //    'path'       => '/udruzenje/prikljuci-se/',
                //    'middleware' => Legacy\JoinAction::class,
                //],
                //[
                //    'name'       => 'legacy.statut',
                //    'path'       => '/udruzenje/statut/',
                //    'middleware' => Legacy\StatutAction::class,
                //],
                //[
                //    'name'       => 'legacy.about',
                //    'path'       => '/zdravo-svete/',
                //    'middleware' => Legacy\AboutAction::class,
                //],
                //[
                //    'name'       => 'legacy.contact',
                //    'path'       => '/kontakt/',
                //    'middleware' => Legacy\ContactAction::class,
                //],
                //[
                //    'name'       => 'legacy.list',
                //    'path'       => '/clanci/',
                //    'middleware' => Legacy\ListAction::class,
                //],
                //[
                //    'name'       => 'legacy.list.pagination',
                //    'path'       => '/clanci/page/:page/',
                //    'middleware' => Legacy\ListAction::class,
                //],
                //[
                //    'name'            => 'home',
                //    'path'            => '/',
                //    'middleware'      => Legacy\IndexAction::class,
                //    'allowed_methods' => ['GET'],
                //],
            ],
        ];
    }
}
