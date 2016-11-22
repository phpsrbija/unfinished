<?php
declare(strict_types = 1);
namespace Test\Admin\Factory\Controller;

class PostFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testPostFactoryShouldCreateExpectedPostControllerInstance()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::once())
            ->method('get')
            ->will(static::returnValue($template));
        $postFactory = new \Admin\Factory\Controller\PostFactory();
        static::assertInstanceOf(\Admin\Controller\PostController::class, $postFactory($container));
    }
}
