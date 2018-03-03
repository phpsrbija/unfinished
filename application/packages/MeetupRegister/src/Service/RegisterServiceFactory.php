<?php

declare(strict_types=1);

namespace MeetupRegister\Service;

use Interop\Container\ContainerInterface;
use MeetupRegister\Service\RegisterService;
use MeetupRegister\Filter\RegisterFilter;
use ReCaptcha\ReCaptcha;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions as SmtpOptions;

class RegisterServiceFactory
{
    public function __invoke(ContainerInterface $container): RegisterService
    {
        $recaptcha = new ReCaptcha($container->get('config')['recaptcha']['secret']);
        $config     = $container->get('config');
        $mailConfig = $config['gmail_config'];
        $config     = [
            'name'              => 'smtp.gmail.com',
            'host'              => 'smtp.gmail.com',
            'connection_class'  => 'login',
            'port'              => '587',
            'connection_config' => [
                'username' => $mailConfig['username'],
                'password' => $mailConfig['password'],
                'ssl'      => 'tls',
            ]
        ];

        $transport = new SmtpTransport;
        $options   = new SmtpOptions($config);
        $transport->setOptions($options);

        return new RegisterService(
            $container->get(RegisterFilter::class),
            $recaptcha,
            $transport
        );
    }
}
