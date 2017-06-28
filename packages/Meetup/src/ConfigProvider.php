<?php
declare(strict_types=1);
namespace Meetup;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'factories' => [
                    MeetupApiService::class => MeetupApiServiceFactory::class,
                ],
            ],
        ];
    }
}
