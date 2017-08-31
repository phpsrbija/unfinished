<?php

declare(strict_types=1);

namespace ContactUs;

use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * Class ConfigProvider
 *
 * @package ContactUs
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class ConfigProvider
{
    public function __invoke()
    {
        return [
            'templates' => [
                'map'   => [
                    'contact-us/pagination' => __DIR__.'/../templates/partial/pagination.php',
                    'contact-us/errors'     => __DIR__.'/../templates/partial/errors.php'
                ],
                'paths' => [
                    'contact-us' => [__DIR__.'/../templates/contact-us'],
                ]
            ],

            'dependencies'  => [
                'factories' => [
                    Controller\ContactUsController::class => Controller\ContactUsControllerFactory::class,
                    Service\ContactUsService::class       => Service\ContactUsServiceFactory::class,
                    Mapper\ContactUsMapper::class         => Mapper\ContactUsMapperFactory::class,
                    Filter\ContactUsFilter::class         => InvokableFactory::class,
                ]
            ],

            'routes' => [
                [
                    'name'            => 'admin.contact-us',
                    'path'            => '/admin/contact-us/',
                    'middleware'      => Controller\ContactUsController::class,
                    'allowed_methods' => ['GET'],
                ],
                [
                    'name'            => 'admin.contact-us.action',
                    'path'            => '/admin/contact-us/{action}/{id}',
                    'middleware'      => Controller\ContactUsController::class,
                    'allowed_methods' => ['GET', 'POST'],
                ]
            ],

            'view_helpers' => [
                'factories' => [

                ]
            ]
        ];
    }
}
