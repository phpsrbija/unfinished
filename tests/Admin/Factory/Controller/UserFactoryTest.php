<?php
declare(strict_types = 1);
namespace Test\Admin\Factory\Controller;

class UserFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testUserFactoryShouldCreateExpectedUserControllerInstance()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::once())
            ->method('get')
            ->will(static::returnValue($template));
        $userFactory = new \Admin\Factory\Controller\UserFactory();
        static::assertInstanceOf(\Admin\Controller\UserController::class, $userFactory($container));
    }
}
