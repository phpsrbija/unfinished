<?php
declare(strict_types = 1);
namespace Newsletter\Test\Service;

class NewsletterServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Email is not valid!
     */
    public function testRegisterNewShouldThrowExceptionForInvalidEmail()
    {
        $newsletterMapper = $this->getMockBuilder(\Newsletter\Mapper\NewsletterMapper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $newsletterService = new \Newsletter\Service\NewsletterService($newsletterMapper);

        static::assertInstanceOf(\Zend\Paginator\Paginator::class, $newsletterService->registerNew('test'));
    }

    public function testRegisterNewShouldReturnTrue()
    {
        $newsletterMapper = $this->getMockBuilder(\Newsletter\Mapper\NewsletterMapper::class)
            ->setMethods(['insert', 'select', 'current'])
            ->disableOriginalConstructor()
            ->getMock();
        $newsletterMapper->expects(static::once())
            ->method('select')
            ->willReturnSelf();
        $newsletterMapper->expects(static::once())
            ->method('insert')
            ->willReturn(true);
        $newsletterMapper->expects(static::once())
            ->method('current')
            ->willReturn(false);
        $newsletterService = new \Newsletter\Service\NewsletterService($newsletterMapper);

        static::assertSame(true, $newsletterService->registerNew('test@test.com'));
    }

    public function testRegisterNewWithExistingEmailShouldDoNothingAndReturnNull()
    {
        $newsletterMapper = $this->getMockBuilder(\Newsletter\Mapper\NewsletterMapper::class)
            ->setMethods(['select', 'current'])
            ->disableOriginalConstructor()
            ->getMock();
        $newsletterMapper->expects(static::once())
            ->method('select')
            ->willReturnSelf();
        $newsletterMapper->expects(static::once())
            ->method('current')
            ->willReturn(true);
        $newsletterService = new \Newsletter\Service\NewsletterService($newsletterMapper);

        static::assertSame(null, $newsletterService->registerNew('test@test.com'));
    }
}
