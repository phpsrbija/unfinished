<?php

declare(strict_types=1);

namespace Newsletter\Test\Web\Action;

class HelperPostActionTest extends \PHPUnit_Framework_TestCase
{
    public function testHandlePostActionShouldReturnJsonResponseWithError()
    {
        $newsletterService = $this->getMockBuilder(\Newsletter\Service\NewsletterService::class)
            ->disableOriginalConstructor()
            ->setMethods(['registerNew'])
            ->getMockForAbstractClass();
        $newsletterService->expects(static::once())
            ->method('registerNew')
            ->willThrowException(new \Exception('test error', 400));
        $request = $this->getMockBuilder(\Psr\Http\Message\ServerRequestInterface::class)
            ->getMockForAbstractClass();
        $response = $this->getMockBuilder(\Psr\Http\Message\ResponseInterface::class)
            ->getMockForAbstractClass();
        $newsletterAction = new \Newsletter\Web\Action\HandlePostAction($newsletterService);
        static::assertInstanceOf(\Zend\Diactoros\Response\JsonResponse::class, $newsletterAction($request, $response));
    }

    public function testHandlePostActionShouldReturnJsonResponseWithSuccess()
    {
        $newsletterService = $this->getMockBuilder(\Newsletter\Service\NewsletterService::class)
            ->setMethods(['registerNew'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $request = $this->getMockBuilder(\Psr\Http\Message\ServerRequestInterface::class)
            ->getMockForAbstractClass();
        $request->expects(static::once())
            ->method('getParsedBody')
            ->willReturn(['email' => 'test@example.com']);
        $response = $this->getMockBuilder(\Psr\Http\Message\ResponseInterface::class)
            ->getMockForAbstractClass();
        $newsletterAction = new \Newsletter\Web\Action\HandlePostAction($newsletterService);
        static::assertSame('Uspešno ste se prijavili.', \GuzzleHttp\json_decode($newsletterAction($request, $response)->getBody()->getContents())->message);
    }
}
