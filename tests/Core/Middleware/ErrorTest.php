<?php
declare(strict_types = 1);
namespace Test\Core\Middleware;

class ErrorTest extends \PHPUnit_Framework_TestCase
{
    public function testErrorMiddlewareShouldReturnProperHtmlResponseOnException()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $errorMiddleware = new \Core\Middleware\Error($template);
        $exception = new \Exception('error middleware exception', 222);
        $request = new \Zend\Diactoros\ServerRequest();
        $response = new \Zend\Diactoros\Response();
        static::assertInstanceOf(
            'Zend\Diactoros\Response\HtmlResponse',
            $errorMiddleware($exception, $request, $response)
        );
    }

    public function testErrorMiddlewareShouldReturnProperHtmlResponseOnIntStatusCode()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $errorMiddleware = new \Core\Middleware\Error($template);
        $request = new \Zend\Diactoros\ServerRequest();
        $response = new \Zend\Diactoros\Response();
        static::assertInstanceOf(
            'Zend\Diactoros\Response\HtmlResponse',
            $errorMiddleware(506, $request, $response)
        );
    }

    public function testErrorMiddlewareShouldReturnProperHtmlResponseOnUnknownTypeOfError()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $errorMiddleware = new \Core\Middleware\Error($template);
        $request = new \Zend\Diactoros\ServerRequest();
        $response = new \Zend\Diactoros\Response();
        static::assertInstanceOf(
            'Zend\Diactoros\Response\HtmlResponse',
            $errorMiddleware(new \stdClass(), $request, $response)
        );
    }
}
