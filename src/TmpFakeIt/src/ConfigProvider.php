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
                    'name'       => 'soon',
                    'path'       => '/soon',
                    'middleware' => Action\TmpAction::class
                ],
            ],
        ];
    }
}
