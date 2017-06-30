<?php

declare(strict_types=1);

namespace Newsletter\Test\Service;

class NewsletterServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeShouldReturnExpectedInstance()
    {
        $pageMapper = $this->getMockBuilder(\Newsletter\Mapper\NewsletterMapper::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($pageMapper));
        $factory = new \Newsletter\Service\NewsletterServiceFactory();
        static::assertInstanceOf(\Newsletter\Service\NewsletterService::class, $factory($container));
    }
}
