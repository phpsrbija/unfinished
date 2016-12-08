<?php
declare(strict_types = 1);
namespace Test\Admin\Factory\Controller;

class ArticleTableGatewayFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testArticleTableGatewayFactoryShouldCreateExpectedClass()
    {
        $adapter = $this->getMockBuilder('Zend\Db\Adapter\AdapterInterface')
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($adapter));

        $articleGateway = new \Admin\Factory\Db\ArticleTableGatewayFactory();
        static::assertInstanceOf(\Admin\Db\ArticleTableGateway::class, $articleGateway($container));
    }
}
