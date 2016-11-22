<?php
declare(strict_types = 1);
namespace Test\Core\Factory\Middleware;

class ErrorNotFoundFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testErrorNotFoundFactoryShouldReturnInstanceOfCoreMiddlewareNotFoundError()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::once())
            ->method('get')
            ->will(static::returnValue($template));
        $errorNotFoundFactory = new \Core\Factory\Middleware\ErrorNotFoundFactory();
        static::assertInstanceOf('Core\Middleware\ErrorNotFound', $errorNotFoundFactory($container));
    }
}
