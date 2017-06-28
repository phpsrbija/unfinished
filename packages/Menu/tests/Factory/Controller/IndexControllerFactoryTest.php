<?php
declare(strict_types = 1);
namespace Menu\Test\Factory\Controller;

class IndexControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingShouldReturnExpectedInstance()
    {
        $templateMock = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $routerMock = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $menuServiceMock = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($templateMock));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($routerMock));
        $container->expects(static::at(2))
            ->method('get')
            ->will(static::returnValue($menuServiceMock));
        $factory = new \Menu\Factory\Controller\IndexControllerFactory();
        static::assertInstanceOf(\Menu\Controller\IndexController::class, $factory($container));
    }
}