<?php
declare(strict_types = 1);
namespace Test\Web\Action;

class ContactActionTest extends \PHPUnit_Framework_TestCase
{
    public function testContactActionShouldReturnHtmlResponse()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $contactAction = new \Web\Action\ContactAction($template);
        $request = new \Zend\Diactoros\ServerRequest();
        $response = new \Zend\Diactoros\Response();
        static::assertInstanceOf('Zend\Diactoros\Response\HtmlResponse', $contactAction($request, $response));
    }
}
