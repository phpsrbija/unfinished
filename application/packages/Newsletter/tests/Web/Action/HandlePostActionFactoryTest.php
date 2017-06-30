<?php
declare(strict_types = 1);
namespace Newsletter\Test\Web\Action;

class HandlePostActionFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testHandleActionFactoryShouldCreateExpectedActionInstance()
    {
        $newsletterService = $this->getMockBuilder(\Newsletter\Service\NewsletterService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::once())
            ->method('get')
            ->will(static::returnValue($newsletterService));
        $handlePostActionFactory = new \Newsletter\Web\Action\HandlePostActionFactory();
        static::assertInstanceOf(\Newsletter\Web\Action\HandlePostAction::class, $handlePostActionFactory($container));
    }
}

