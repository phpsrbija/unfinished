<?php
declare(strict_types = 1);
namespace Test\Admin\Controller;

abstract class ControllerTest extends \PHPUnit_Framework_TestCase
{
    public function getTemplate(array $methods) : \Zend\Expressive\Template\TemplateRendererInterface
    {
        return $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->setMethods($methods)
            ->getMockForAbstractClass();
    }

    public function getSessionManager(array $methods) : \Zend\Session\SessionManager
    {
        return $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->setMethods($methods)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function getRouter(array $methods) : \Zend\Expressive\Router\RouterInterface
    {
        return $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->setMethods($methods)
            ->getMockForAbstractClass();
    }

    public function getRequest() : \Zend\Diactoros\ServerRequest
    {
        return new \Zend\Diactoros\ServerRequest();
    }

    public function getResponse() : \Zend\Diactoros\Response
    {
        return new \Zend\Diactoros\Response();
    }
}
