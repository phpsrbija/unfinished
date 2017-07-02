<?php

declare(strict_types=1);

namespace Admin\Test\Factory;

class SessionFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testSessionFactoryShouldCreateInstanceOfSessionManager()
    {
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $sessionFactory = new \Admin\Factory\SessionFactory();
        static::assertInstanceOf(\Zend\Session\SessionManager::class, $sessionFactory($container));
    }
}
