<?php
declare(strict_types = 1);
namespace Test\Web\Factory\Action;

class IndexFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testWebIndexActionFactoryShouldCreateIndexActionInstance()
    {
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::once())
            ->method('get')
            ->will(static::returnValue($template));
        $indexActionFactory = new \Web\Factory\Action\IndexFactory();
        static::assertInstanceOf('Web\Action\IndexAction', $indexActionFactory($container));
    }
}
