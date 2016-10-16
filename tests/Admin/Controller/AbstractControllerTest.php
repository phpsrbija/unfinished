<?php
declare(strict_types = 1);
namespace Test\Admin\Controller;

class AbstractControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingControllerWithNonExistentActionShouldTrigger404Response()
    {
        $request = $this->getMockBuilder('Psr\Http\Message\ServerRequestInterface')
            ->setMethods(['getAttribute'])
            ->getMockForAbstractClass();
        $request->expects(static::at(0))
            ->method('getAttribute')
            ->will(static::returnValue('nonExistentAction'));
        $response = new \Zend\Diactoros\Response();
        $controller = new ControllerStub();
        $response = $controller(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        );
        static::assertSame(404, $response->getStatusCode());
    }
}

class ControllerStub extends \Admin\Controller\AbstractController
{

}
