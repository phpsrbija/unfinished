<?php

namespace Web;

use Zend\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'templates' => [
                'map'    => [
                    'layout/legacy'    => 'templates/layout/legacy.phtml',
                ],
                'paths'  => [
                    'web'    => ['templates/web'],
                    'legacy' => ['templates/legacy'],
                ],
            ],

            'dependencies' => [
                'factories' => [
                    // Web
                    Action\PingAction::class    => InvokableFactory::class,
                    Action\IndexAction::class   => Factory\Action\IndexFactory::class,
                    Action\AboutAction::class   => Factory\Action\TemplateFactory::class,
                    Action\ContactAction::class => Factory\Action\TemplateFactory::class,

                    // Legacy
                    Legacy\SingleAction::class  => Factory\Legacy\SingleFactory::class,
                    Legacy\JoinAction::class    => Factory\Legacy\JoinFactory::class,
                    Legacy\AboutAction::class   => Factory\Legacy\AboutFactory::class,
                    Legacy\StatutAction::class  => Factory\Legacy\StatutFactory::class,
                    Legacy\ContactAction::class => Factory\Legacy\ContactFactory::class,
                    Legacy\ContactAction::class => Factory\Legacy\ContactFactory::class,
                    Legacy\ListAction::class    => Factory\Legacy\ListFactory::class,
                    Legacy\IndexAction::class   => Factory\Legacy\IndexFactory::class,
                ],
            ],

            'routes' => [
                // Legacy
                [
                    'name'       => 'single',
                    'path'       => '/single/:slug/',
                    'middleware' => Legacy\SingleAction::class,
                ],
                [
                    'name'       => 'legacy.join',
                    'path'       => '/udruzenje/prikljuci-se/',
                    'middleware' => Legacy\JoinAction::class,
                ],
                [
                    'name'       => 'legacy.statut',
                    'path'       => '/udruzenje/statut/',
                    'middleware' => Legacy\StatutAction::class,
                ],
                [
                    'name'       => 'legacy.about',
                    'path'       => '/zdravo-svete/',
                    'middleware' => Legacy\AboutAction::class,
                ],
                [
                    'name'       => 'legacy.contact',
                    'path'       => '/kontakt/',
                    'middleware' => Legacy\ContactAction::class,
                ],
                [
                    'name'       => 'legacy.list',
                    'path'       => '/clanci/',
                    'middleware' => Legacy\ListAction::class,
                ],
                [
                    'name'       => 'legacy.list.pagination',
                    'path'       => '/clanci/page/:page/',
                    'middleware' => Legacy\ListAction::class,
                ],
                [
                    'name'            => 'home',
                    'path'            => '/',
                    'middleware'      => Legacy\IndexAction::class,
                    'allowed_methods' => ['GET'],
                ],

                // Web
                [
                    'name'       => 'about',
                    'path'       => '/about-us',
                    'middleware' => Action\AboutAction::class,
                ],
                [
                    'name'       => 'contact',
                    'path'       => '/contact-us',
                    'middleware' => Action\ContactAction::class,
                ],
                [
                    'name'            => 'api.ping',
                    'path'            => '/api/ping',
                    'middleware'      => Action\PingAction::class,
                    'allowed_methods' => ['GET'],
                ],

            ],
        ];
    }
}
