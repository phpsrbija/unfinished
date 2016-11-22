<?php
declare(strict_types = 1);
namespace Test\Web\Action;

class PingActionTest extends \PHPUnit_Framework_TestCase
{
    public function testPingActionShouldReturnJsonResponseWithAck()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $pingAction = new \Web\Action\PingAction($template);
        $request = new \Zend\Diactoros\ServerRequest();
        $response = new \Zend\Diactoros\Response();
        /** @var \Zend\Diactoros\Response\JsonResponse $jsonResponse */
        $jsonResponse = $pingAction($request, $response);
        static::assertInstanceOf('Zend\Diactoros\Response\JsonResponse', $jsonResponse);
        $json = json_decode($jsonResponse->getBody()->getContents());
        static::assertObjectHasAttribute('ack', $json);
        static::assertAttributeInternalType('int', 'ack', $json);
    }
}
