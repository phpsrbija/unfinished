<?php
declare(strict_types = 1);
namespace Test\Admin\Factory\Controller;

class EventFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testPostFactoryShouldCreateExpectedPostControllerInstance()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $eventService = $this->getMockBuilder(\Core\Service\EventService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $session = $this->getMockBuilder(\Zend\Session\SessionManager::class)
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
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($eventService));
        $container->expects(static::at(2))
            ->method('get')
            ->will(static::returnValue($session));
        $container->expects(static::at(4))
            ->method('get')
            ->will(static::returnValue($tagService));
        $postFactory = new \Admin\Factory\Controller\EventFactory();
        static::assertInstanceOf(\Admin\Controller\EventController::class, $postFactory($container));
    }
}
