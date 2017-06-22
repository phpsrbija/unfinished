<?php
declare(strict_types=1);

namespace Meetup;

use Interop\Container\ContainerInterface;

class MeetupApiServiceFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param  ContainerInterface $container container
     * @return MeetupApiService
     */
    public function __invoke(ContainerInterface $container): MeetupApiService
    {
        $config = $container->get('config')['meetupApi'];

        return new MeetupApiService($config['key']);
    }
}
