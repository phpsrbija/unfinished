<?php
declare(strict_types=1);
namespace MeetupRegister;

use Zend\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'templates' => [
                'paths' => [
                    'meetupregister' => [__DIR__.'/../templates/register'],
                ],
            ],

            'dependencies' => [
                'factories' => [
                    Web\Action\FormAction::class => Web\Action\FormActionFactory::class,
                    Web\Action\HandleFormAction::class => Web\Action\HandleActionFactory::class,
                    Service\RegisterService::class => Service\RegisterServiceFactory::class,
                    Filter\RegisterFilter::class => InvokableFactory::class,
                ],
            ],

            'routes' => [
                [
                    'name'            => 'meetup-register',
                    'path'            => '/meetup-register/',
                    'middleware'      => Web\Action\FormAction::class,
                    'allowed_methods' => ['GET'],
                ],
                [
                    'name'            => 'submit-meetup-register',
                    'path'            => '/submit-meetup-register',
                    'middleware'      => Web\Action\HandleFormAction::class,
                    'allowed_methods' => ['POST'],
                ],
            ],
        ];
    }
}
