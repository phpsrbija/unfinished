<?php
declare(strict_types = 1);
namespace Test\Web\Factory\Middleware;

class LayoutFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testLayoutFactoryShouldCreateLayoutMiddlewareInstance()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $config = new \ArrayObject();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($template));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($config));
        $layoutFactory = new \Web\Factory\Middleware\LayoutFactory();
        static::assertInstanceOf('Web\Middleware\Layout', $layoutFactory($container));
    }
}
