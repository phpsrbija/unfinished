<?php
declare(strict_types = 1);
namespace Test\Article\View\Helper;

class VideoHelperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingFactoryShouldReturnExpectedInstance()
    {
        $videoService = $this->getMockBuilder('Article\Service\VideoService')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($videoService));
        $factory = new \Article\Factory\View\Helper\VideoHelperFactory();
        static::assertInstanceOf(\Article\View\Helper\VideoHelper::class, $factory($container, 'test'));
    }
}