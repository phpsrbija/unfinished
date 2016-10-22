<?php
declare(strict_types = 1);
namespace Test\Web\Action;

class AboutActionTest extends \PHPUnit_Framework_TestCase
{
    public function testAboutActionShouldReturnHtmlResponse()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $aboutAction = new \Web\Action\AboutAction($template);
        $request = new \Zend\Diactoros\ServerRequest();
        $response = new \Zend\Diactoros\Response();
        static::assertInstanceOf('Zend\Diactoros\Response\HtmlResponse', $aboutAction($request, $response));
    }
}
