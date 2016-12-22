<?php
declare(strict_types = 1);
namespace Test\Admin\Factory\Controller;

class ArticleRepositoryFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testArticleRepositoryFactoryShouldCreateExpectedRepository()
    {
        $storage = $this->getMockBuilder('Admin\Mapper\ArticleMapper')
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($storage));

        $articleRepoFactory = new \Admin\Factory\Model\Repository\ArticleRepositoryFactory();
        static::assertInstanceOf(\Admin\Model\Repository\ArticleRepository::class, $articleRepoFactory($container));
    }
}
