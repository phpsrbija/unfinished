<?php

declare(strict_types=1);

namespace Register\Service;

use Interop\Container\ContainerInterface;
use Register\Filter\RegisterFilter;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

class RegisterServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
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
            $transport
        );
    }
}