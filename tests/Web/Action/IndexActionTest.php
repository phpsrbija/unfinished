<?php
declare(strict_types = 1);
namespace Test\Web\Action;

class IndexActionTest extends \PHPUnit_Framework_TestCase
{
    public function testIndexActionShouldReturnHtmlResponse()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $indexAction = new \Web\Action\IndexAction($template);
        $request = new \Zend\Diactoros\ServerRequest();
        $response = new \Zend\Diactoros\Response();
        static::assertInstanceOf('Zend\Diactoros\Response\HtmlResponse', $indexAction($request, $response));
    }
}
