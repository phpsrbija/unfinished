<?php
declare(strict_types = 1);
namespace Test\Admin\Controller;

class TagControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testIndexMethodShouldReturnHtmlResponse()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $tagService = $this->getMockBuilder(\Core\Service\TagService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'index');
        $response = new \Zend\Diactoros\Response();
        $tagController = new \Admin\Controller\TagController($template, $router, $tagService);
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $tagController($request, $response));
    }
}
