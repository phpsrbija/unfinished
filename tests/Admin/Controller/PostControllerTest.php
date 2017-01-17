<?php
declare(strict_types = 1);
namespace Test\Admin\Controller;

class PostControllerTest extends \PHPUnit_Framework_TestCase
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
        $postService = $this->getMockBuilder(\Core\Service\PostService::class)
            ->disableOriginalConstructor()
            ->setMethods(['fetchAllArticles'])
            ->getMock();
        $postService->expects(static::once())
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
        $postController = new \Admin\Controller\PostController(
            $template,
            $postService,
            $sessionManager,
            $router,
            $tagService
        );
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $postController($request, $response));
    }
}
