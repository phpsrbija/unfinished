<?php
declare(strict_types = 1);
namespace Admin\Test\Factory;


class FilterFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFilterFactoryShouldCreateInstanceAdminUserFilter()
    {
        $adapterMapper = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($adapterMapper));
        $filterFactory = new \Admin\Factory\FilterFactory();
        static::assertInstanceOf(\Admin\Filter\AdminUserFilter::class, $filterFactory($container, \Admin\Filter\AdminUserFilter::class));
    }
}
