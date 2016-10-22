<?php
declare(strict_types = 1);
namespace Test\Core\Factory;

class SessionFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testSessionFactoryShouldCreateSessionManagerInstance()
    {
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $sessionFactory = new \Core\Factory\SessionFactory();
        static::assertInstanceOf('Zend\Session\SessionManager', $sessionFactory($container));
    }
}
