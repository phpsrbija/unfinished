<?php
declare(strict_types = 1);
namespace Test\Core\Factory;

class MapperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMapperFactoryShouldCreateInstanceOfMapperFromRequestedName()
    {
        $dbAdapter = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
            ->disableOriginalConstructor()
            ->getMock();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::once())
            ->method('get')
            ->will(static::returnValue($dbAdapter));
        $mapperFactory = new \Core\Factory\MapperFactory();
        static::assertInstanceOf(
            'Core\Mapper\AdminUsersMapper',
            $mapperFactory($container, 'Core\Mapper\AdminUsersMapper')
        );
    }
}
