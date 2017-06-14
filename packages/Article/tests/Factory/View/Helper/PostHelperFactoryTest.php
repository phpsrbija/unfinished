<?php
declare(strict_types = 1);
namespace Test\Article\View\Helper;

class PostHelperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingFactoryShouldReturnExpectedInstance()
    {
        $postService = $this->getMockBuilder('Article\Service\PostService')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($postService));
        $factory = new \Article\Factory\View\Helper\PostHelperFactory();
        static::assertInstanceOf(\Article\View\Helper\PostHelper::class, $factory($container, 'test'));
    }
}