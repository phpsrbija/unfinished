<?php

namespace Newsletter;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'templates' => [
                'paths' => [
                    'newsletter' => [__DIR__ . '/../templates/newsletter'],
                ],
            ],

            'dependencies' => [
                'factories' => [
                    Web\Action\HandlePostAction::class => Web\Action\HandlePostActionFactory::class,
                    Service\NewsletterService::class   => Service\NewsletterServiceFactory::class,
                    Mapper\NewsletterMapper::class     => Mapper\NewsletterMapperFactory::class
                ],
            ],

            'routes' => [
                [
                    'name'            => 'newsletter-post',
                    'path'            => '/newsletter',
                    'middleware'      => Web\Action\HandlePostAction::class,
                    'allowed_methods' => ['POST'],
                ],
            ],
        ];
    }
}
