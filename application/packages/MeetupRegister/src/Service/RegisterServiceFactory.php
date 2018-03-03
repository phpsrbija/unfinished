<?php

declare(strict_types=1);

namespace MeetupRegister\Service;

use Interop\Container\ContainerInterface;
use MeetupRegister\Service\RegisterService;
use MeetupRegister\Filter\RegisterFilter;
use ReCaptcha\ReCaptcha;

class RegisterServiceFactory
{
    public function __invoke(ContainerInterface $container): RegisterService
    {
        $recaptcha = new ReCaptcha($container->get('config')['recaptcha']['secret']);

        return new RegisterService(
            $container->get(RegisterFilter::class),
            $recaptcha
        );
    }
}
