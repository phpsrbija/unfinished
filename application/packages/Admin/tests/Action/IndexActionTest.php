<?php

declare(strict_types=1);

namespace Test\Admin\Action;

class IndexActionTest extends \PHPUnit_Framework_TestCase
{
    public function testIndexActionShouldReturnHtmlResponse()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('rendered index action'));
        $request = $this->getMockBuilder('Psr\Http\Message\ServerRequestInterface')
            ->getMockForAbstractClass();
        $response = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')
            ->getMockForAbstractClass();
        $indexAction = new \Admin\Action\IndexAction($template);
        static::assertInstanceOf('Zend\Diactoros\Response\HtmlResponse', $indexAction($request, $response));
    }
}
