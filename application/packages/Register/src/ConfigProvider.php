<?php

declare(strict_types=1);

namespace Register;

use Zend\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'templates'    => [
                'paths' => [
                    'register' => [__DIR__ . '/../templates/register'],
                ],
            ],
            'dependencies' => [
                'factories' => [
                    Action\RegisterAction::class       => Action\RegisterActionFactory::class,
                    Action\HandleRegisterAction::class => Action\HandleRegisterActionFactory::class,
                    Service\RegisterService::class     => Service\RegisterServiceFactory::class,
                    Filter\RegisterFilter::class       => InvokableFactory::class,
                ],
            ],

            'routes' => [
                [
                    'name'            => 'register',
                    'path'            => '/register',
                    'middleware'      => Action\RegisterAction::class,
                    'allowed_methods' => ['GET'],
                ],
                [
                    'name'            => 'register-handle',
                    'path'            => '/register-handle',
                    'middleware'      => Action\HandleRegisterAction::class,
                    'allowed_methods' => ['POST'],
                ]
            ],
        ];
    }
}
