<?php
declare(strict_types = 1);
namespace Test\Core\Factory\Middleware;

class ErrorFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testErrorFactoryShouldReturnInstanceOfCoreMiddlewareError()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::once())
            ->method('get')
            ->will(static::returnValue($template));
        $errorFactory = new \Core\Factory\Middleware\ErrorFactory();
        static::assertInstanceOf('Core\Middleware\Error', $errorFactory($container));
    }
}
