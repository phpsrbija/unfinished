<?php
declare(strict_types = 1);
namespace Test\Admin\Factory\Action;

class IndexFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testIndexActionFactoryShouldCreateExpectedActionInstance()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::once())
            ->method('get')
            ->will(static::returnValue($template));
        $indexFactory = new \Admin\Factory\Action\IndexFactory();
        static::assertInstanceOf('Admin\Action\IndexAction', $indexFactory($container));
    }
}
