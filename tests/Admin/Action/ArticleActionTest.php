<?php
declare(strict_types = 1);

namespace Test\Admin\Action;

class ArticleActionTest extends \PHPUnit_Framework_TestCase
{
    public function testIndexActionShouldReturnExpectedHtmlResponse()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->setMethods(array('render'))
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('rendered article index action'));
        $request = $this->getMockBuilder('Psr\Http\Message\ServerRequestInterface')
            ->setMethods(array('getAttribute'))
            ->getMockForAbstractClass();
        $request->expects(static::once())
            ->method('getAttribute')
            ->willReturn('index');
        $response = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')
            ->getMockForAbstractClass();
        $articleRepoInterface = $this->getMockBuilder('Admin\Model\Repository\ArticleRepositoryInterface')
            ->getMockForAbstractClass();
        $articleValidator = $this->getMockBuilder('Admin\Validator\ValidatorInterface')
            ->getMockForAbstractClass();
        $next = $this->getMockBuilder('Zend\Stratigility\Next')
            ->disableOriginalConstructor()
            ->getMock();
        $indexAction = new \Admin\Action\ArticlePageAction($template, $articleRepoInterface, $articleValidator);
        /* @var \Zend\Diactoros\Response\HtmlResponse $htmlResponse */
        $htmlResponse = $indexAction($request, $response, $next);

        static::assertInstanceOf('Zend\Diactoros\Response\HtmlResponse', $htmlResponse);
    }

    public function testCreateActionWithInvalidPostDataShouldReturnExpectedHtmlResponse()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->setMethods(array('render'))
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('rendered article create action'));
        $request = $this->getMockBuilder('Psr\Http\Message\ServerRequestInterface')
            ->setMethods(array('getAttribute', 'getParsedBody'))
            ->getMockForAbstractClass();
        $request->expects(static::once())
            ->method('getAttribute')
            ->willReturn('create');
        $request->expects(static::once())
            ->method('getParsedBody')
            ->willReturn(array('title' => 'test title'));
        $response = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')
            ->getMockForAbstractClass();
        $articleRepoInterface = $this->getMockBuilder('Admin\Model\Repository\ArticleRepositoryInterface')
            ->getMockForAbstractClass();
        $articleValidator = $this->getMockBuilder('Admin\Validator\ValidatorInterface')
            ->setMethods(array('validate'))
            ->getMockForAbstractClass();
        $articleValidator->expects(static::once())
            ->method('validate')
            ->willThrowException(new \Admin\Validator\ValidatorException('test error'));
        $next = $this->getMockBuilder('Zend\Stratigility\Next')
            ->disableOriginalConstructor()
            ->getMock();

        $articleAction = new \Admin\Action\ArticlePageAction($template, $articleRepoInterface, $articleValidator);
        /* @var \Zend\Diactoros\Response\HtmlResponse $htmlResponse */
        $htmlResponse = $articleAction($request, $response, $next);

        static::assertInstanceOf('Zend\Diactoros\Response\HtmlResponse', $htmlResponse);
    }
}
