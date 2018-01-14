<?php

declare(strict_types=1);

namespace Test\Article\Controller;

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
        $eventService = $this->getMockBuilder(\Article\Service\EventService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sessionManager = $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'index');
        $response = new \Zend\Diactoros\Response();
        $eventController = new \Article\Controller\EventController(
            $template,
            $router,
            $eventService,
            $sessionManager,
            $categoryService
        );
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $eventController($request, $response));
    }

    public function testEditMethodShouldReturnHtmlResponse()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage();
        $sessionStorage->user = $user;
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $eventService = $this->getMockBuilder(\Article\Service\EventService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sessionManager = $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'edit');
        $request = $request->withAttribute('id', 1);
        $response = new \Zend\Diactoros\Response();
        $eventController = new \Article\Controller\EventController(
            $template,
            $router,
            $eventService,
            $sessionManager,
            $categoryService
        );
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $eventController($request, $response));
    }

    public function testEditMethodShouldReturnHtmlResponseAndUpdateObjectWithRequestData()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage();
        $sessionStorage->user = $user;
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $eventService = $this->getMockBuilder(\Article\Service\EventService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sessionManager = $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'edit');
        $request = $request->withAttribute('id', 1);
        $request = $request->withParsedBody(['event' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $eventController = new \Article\Controller\EventController(
            $template,
            $router,
            $eventService,
            $sessionManager,
            $categoryService
        );
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $eventController($request, $response));
    }

    public function testSaveMethodShouldCreateEventAndReturnRedirect()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage(
            [
            'user' => true,
            ]
        );
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->setStorage($sessionStorage);
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $eventService = $this->getMockBuilder(\Article\Service\EventService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.test/admin'));
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'save');
        $request = $request->withParsedBody(['event' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $eventController = new \Article\Controller\EventController(
            $template,
            $router,
            $eventService,
            $sessionManager,
            $categoryService
        );
        /**
         * @var \Zend\Diactoros\Response
         */
        $returnedResponse = $eventController($request, $response);
        static::assertSame(302, $returnedResponse->getStatusCode());
    }

    public function testSaveMethodShouldUpdateEventAndReturnRedirect()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage(
            [
            'user' => true,
            ]
        );
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->setStorage($sessionStorage);
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $eventService = $this->getMockBuilder(\Article\Service\EventService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.test/admin'));
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'save');
        $request = $request->withAttribute('id', 2);
        $request = $request->withParsedBody(['event' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $eventController = new \Article\Controller\EventController(
            $template,
            $router,
            $eventService,
            $sessionManager,
            $categoryService
        );
        /**
         * @var \Zend\Diactoros\Response
         */
        $returnedResponse = $eventController($request, $response);
        static::assertSame(302, $returnedResponse->getStatusCode());
    }

    public function testSaveMethodShouldThrowFilterExceptionAndReturnHtmlResponse()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage(
            [
            'user' => true,
            ]
        );
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->setStorage($sessionStorage);
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $eventService = $this->getMockBuilder(\Article\Service\EventService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $eventService->expects(static::once())
            ->method('updateArticle')
            ->willThrowException(new \Std\FilterException(['test error']));
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'save');
        $request = $request->withAttribute('id', 2);
        $request = $request->withParsedBody(['event' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $eventController = new \Article\Controller\EventController(
            $template,
            $router,
            $eventService,
            $sessionManager,
            $categoryService
        );
        /**
         * @var \Zend\Diactoros\Response
         */
        $returnedResponse = $eventController($request, $response);
        static::assertSame(200, $returnedResponse->getStatusCode());
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $returnedResponse);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage test error
     */
    public function testSaveMethodShouldThrowException()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage(
            [
            'user' => true,
            ]
        );
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->setStorage($sessionStorage);
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $eventService = $this->getMockBuilder(\Article\Service\EventService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $eventService->expects(static::once())
            ->method('updateArticle')
            ->willThrowException(new \Exception('test error'));
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'save');
        $request = $request->withAttribute('id', 2);
        $request = $request->withParsedBody(['event' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $eventController = new \Article\Controller\EventController(
            $template,
            $router,
            $eventService,
            $sessionManager,
            $categoryService
        );
        $eventController($request, $response);
    }

    public function testDeleteMethodShouldSucceedAndReturnRedirect()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage(
            [
            'user' => true,
            ]
        );
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->setStorage($sessionStorage);
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $eventService = $this->getMockBuilder(\Article\Service\EventService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.test/admin'));
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'delete');
        $request = $request->withAttribute('id', 2);
        $response = new \Zend\Diactoros\Response();
        $eventController = new \Article\Controller\EventController(
            $template,
            $router,
            $eventService,
            $sessionManager,
            $categoryService
        );
        /**
         * @var \Zend\Diactoros\Response
         */
        $returnedResponse = $eventController($request, $response);
        static::assertSame(302, $returnedResponse->getStatusCode());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage test error
     */
    public function testDeleteMethodShouldFailAndThrowException()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage(
            [
            'user' => true,
            ]
        );
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->setStorage($sessionStorage);
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $eventService = $this->getMockBuilder(\Article\Service\EventService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $eventService->expects(static::once())
            ->method('deleteArticle')
            ->willThrowException(new \Exception('test error'));
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'delete');
        $request = $request->withAttribute('id', 2);
        $response = new \Zend\Diactoros\Response();
        $eventController = new \Article\Controller\EventController(
            $template,
            $router,
            $eventService,
            $sessionManager,
            $categoryService
        );
        $eventController($request, $response);
    }
}
