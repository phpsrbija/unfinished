<?php
declare(strict_types = 1);
namespace Test\Core\Middleware;

class ErrorNotFoundTest extends \PHPUnit_Framework_TestCase
{
    public function testErrorNotFoundMiddlewareShouldReturnProperHtmlResponse()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $errorMiddleware = new \Core\Middleware\ErrorNotFound($template);
        $request = new \Zend\Diactoros\ServerRequest();
        $response = new \Zend\Diactoros\Response();
        static::assertInstanceOf(
            'Zend\Diactoros\Response\HtmlResponse',
            $errorMiddleware($request, $response)
        );
    }
}
