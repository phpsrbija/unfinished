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
        $tagController = new \Admin\Controller\TagController($template);
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $tagController->index());
    }
}
