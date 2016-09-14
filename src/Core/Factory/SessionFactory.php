<?php

namespace Core\Factory;

use Interop\Container\ContainerInterface;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;
use Zend\Session\Container;

class SessionFactory
{
    const SESSION_CONF = [
        'remember_me_seconds' => 2592000, //2592000, // 30 * 24 * 60 * 60 = 30 days
        'use_cookies'         => true,
        'cookie_httponly'     => true,
        'name'                => 'admin',
        'cookie_lifetime'     => 2592000,
        'gc_maxlifetime'      => 2592000
    ];

    public function __invoke(ContainerInterface $container)
    {
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions(self::SESSION_CONF);

        $session = new SessionManager($sessionConfig);
        $session->start();

        return $session;
    }
}
