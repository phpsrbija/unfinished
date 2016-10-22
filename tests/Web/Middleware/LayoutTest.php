<?php
declare(strict_types = 1);
namespace Test\Web\Middleware;

class LayoutTest extends \PHPUnit_Framework_TestCase
{
    public function testLayoutMiddlewareShouldSetAdminLayoutIfUriLeadsToAdmin()
    {
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->getMockForAbstractClass();
        $config = new \ArrayObject([
            'templates' => [
                'layout' => 'default',
            ],
        ]);
        $layout = new \Web\Middleware\Layout($router, $config);
        $request = new \Zend\Diactoros\ServerRequest([], [], 'http://example.org/admin');
        $response = new \Zend\Diactoros\Response();
        $layout($request, $response, function ($request, $response) {

        });
        static::assertSame('layout/admin', $config['templates']['layout']);
    }

    public function testLayoutMiddlewareShouldNotSetAdminLayoutIfUriDoesntLeadToAdmin()
    {
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->getMockForAbstractClass();
        $config = new \ArrayObject([
            'templates' => [
                'layout' => 'default',
            ],
        ]);
        $layout = new \Web\Middleware\Layout($router, $config);
        $request = new \Zend\Diactoros\ServerRequest([], [], 'http://example.org');
        $response = new \Zend\Diactoros\Response();
        $layout($request, $response, function ($request, $response) {

        });
        static::assertSame('default', $config['templates']['layout']);
    }
}
