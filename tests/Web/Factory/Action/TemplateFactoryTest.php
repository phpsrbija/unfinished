<?php
declare(strict_types = 1);
namespace Test\Web\Factory\Action;

class TemplateFactoryAction extends \PHPUnit_Framework_TestCase
{
    public function testTemplateFactoryShouldCreateWebActionInstanceFromRequestedName()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::once())
            ->method('get')
            ->will(static::returnValue($template));
        $templateFactory = new \Web\Factory\Action\TemplateFactory();
        static::assertInstanceOf('Web\Action\AboutAction', $templateFactory($container, 'Web\Action\AboutAction'));
    }
}
