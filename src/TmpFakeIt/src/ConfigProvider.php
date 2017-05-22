<?php

namespace TmpFakeIt;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'factories' => [
                    Action\TmpAction::class => Action\TmpActionFactory::class,
                ],
            ],

            'routes' => [
                [
                    'name'       => 'fake-it',
                    'path'       => '/fake-it-til-you-make-it',
                    'middleware' => Action\TmpAction::class
                ],
            ],
        ];
    }
}
