<?php
declare(strict_types = 1);
namespace Test\Admin\Factory\Controller;

class TagFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testTagFactoryShouldCreateExpectedTagControllerInstance()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $tagService = $this->getMockBuilder(\Core\Service\TagService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($template));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($router));
        $container->expects(static::at(2))
            ->method('get')
            ->will(static::returnValue($tagService));
        $tagFactory = new \Admin\Factory\Controller\TagFactory();
        static::assertInstanceOf(\Admin\Controller\TagController::class, $tagFactory($container));
    }
}
