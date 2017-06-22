<?php
declare(strict_types = 1);
namespace Menu\Test\Controller;

class IndexControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testIndexMethodShouldReturnHtmlResponse()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'index');
        $response = new \Zend\Diactoros\Response();
        $indexController = new \Menu\Controller\IndexController(
            $template,
            $router,
            $menuService
        );
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $indexController($request, $response));
    }

    public function testEditMethodShouldReturnHtmlResponseAndGetIdFromRequest()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'edit');
        $request = $request->withAttribute('id', 1);
        $request = $request->withParsedBody(['menu' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $indexController = new \Menu\Controller\IndexController(
            $template,
            $router,
            $menuService
        );
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $indexController($request, $response));
    }

    public function testSaveMethodShouldCreateCategoryAndReturnRedirect()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.dev/admin'));
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'save');
        $request = $request->withParsedBody(['menu' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $indexController = new \Menu\Controller\IndexController(
            $template,
            $router,
            $menuService
        );
        $returnedResponse = $indexController($request, $response);
        static::assertSame(302, $returnedResponse->getStatusCode());
    }

    public function testSaveMethodShouldUpdateCategoryAndReturnRedirect()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.dev/admin'));
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'save');
        $request = $request->withAttribute('id', 1);
        $request = $request->withParsedBody(['menu' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $indexController = new \Menu\Controller\IndexController(
            $template,
            $router,
            $menuService
        );
        $returnedResponse = $indexController($request, $response);
        static::assertSame(302, $returnedResponse->getStatusCode());
    }

    public function testSaveMethodShouldThrowFilterExceptionAndReturnHtmlResponse()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService->expects(static::once())
            ->method('updateMenuItem')
            ->willThrowException(new \Std\FilterException(['test error']));
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'save');
        $request = $request->withAttribute('id', 2);
        $request = $request->withParsedBody(['menu' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $indexController = new \Menu\Controller\IndexController(
            $template,
            $router,
            $menuService
        );

        $returnedResponse = $indexController($request, $response);
        static::assertSame(200, $returnedResponse->getStatusCode());
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $returnedResponse);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage test error
     */
    public function testSaveMethodShouldThrowException()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService->expects(static::once())
            ->method('updateMenuItem')
            ->willThrowException(new \Exception('test error'));
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'save');
        $request = $request->withAttribute('id', 2);
        $request = $request->withParsedBody(['menu' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $indexController = new \Menu\Controller\IndexController(
            $template,
            $router,
            $menuService
        );
        $indexController($request, $response);
    }

    public function testDeleteMethodShouldSucceedAndReturnRedirect()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.dev/admin'));
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'delete');
        $request = $request->withAttribute('id', 2);
        $response = new \Zend\Diactoros\Response();
        $indexController = new \Menu\Controller\IndexController(
            $template,
            $router,
            $menuService
        );
        $returnedResponse = $indexController($request, $response);
        static::assertSame(302, $returnedResponse->getStatusCode());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage test error
     */
    public function testDeleteMethodShouldFailThrowException()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService->expects(static::once())
            ->method('delete')
            ->willThrowException(new \Exception('test error'));
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'delete');
        $request = $request->withAttribute('id', 2);
        $response = new \Zend\Diactoros\Response();
        $indexController = new \Menu\Controller\IndexController(
            $template,
            $router,
            $menuService
        );
        $returnedResponse = $indexController($request, $response);
        static::assertSame(302, $returnedResponse->getStatusCode());
    }

    public function testUpdateOrderMethodShouldReturnJsonResponse()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService->expects(static::once())
            ->method('updateMenuOrder')
            ->willReturn('test');
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'updateOrder');
        $request = $request->withAttribute('id', 2);
        $request = $request->withParsedBody(['menu' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $indexController = new \Menu\Controller\IndexController(
            $template,
            $router,
            $menuService
        );
        static::assertInstanceOf(\Zend\Diactoros\Response\JsonResponse::class, $indexController($request, $response));
    }
}