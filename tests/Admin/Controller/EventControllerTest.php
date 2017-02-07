<?php
declare(strict_types = 1);
namespace Test\Admin\Controller;

class EventControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testIndexMethodShouldReturnHtmlResponse()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $paginator = $this->getMockBuilder(\Zend\Paginator\Paginator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $eventService = $this->getMockBuilder(\Core\Service\EventService::class)
            ->disableOriginalConstructor()
            ->setMethods(['fetchAllArticles'])
            ->getMock();
        $eventService->expects(static::once())
            ->method('fetchAllArticles')
            ->will(static::returnValue($paginator));
        $sessionManager = $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $tagService = $this->getMockBuilder(\Core\Service\TagService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'index');
        $response = new \Zend\Diactoros\Response();
        $postController = new \Admin\Controller\EventController(
            $template,
            $router,
            $eventService,
            $sessionManager,
            $tagService
        );
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $postController($request, $response));
    }
}
