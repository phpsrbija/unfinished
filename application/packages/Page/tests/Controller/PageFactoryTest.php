<?php

declare(strict_types=1);

namespace Test\Page\Controller;

class PageFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingFactoryShouldReturnExpectedInstance()
    {
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
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
            ->will(static::returnValue($pageService));
        $factory = new \Page\Controller\PageControllerFactory();
        static::assertInstanceOf(\Page\Controller\PageController::class, $factory($container));
    }
}
