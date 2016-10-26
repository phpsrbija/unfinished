<?php
declare(strict_types = 1);
namespace Test\Admin\Factory\Controller;

class TagFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testTagFactoryShouldCreateExpectedTagControllerInstance()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::once())
            ->method('get')
            ->will(static::returnValue($template));
        $tagFactory = new \Admin\Factory\Controller\TagFactory();
        static::assertInstanceOf(\Admin\Controller\TagController::class, $tagFactory($container));
    }
}
