<?php
declare(strict_types = 1);
namespace Test\Article\Controller;

class PostServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingFactoryShouldReturnExpectedInstance()
    {
        $articleMapper = $this->getMockBuilder(\Article\Mapper\ArticleMapper::class)
            ->getMockForAbstractClass();
        $articlePostMapper = $this->getMockBuilder(\Article\Mapper\ArticlePostsMapper::class)
            ->getMockForAbstractClass();
        $articleFilter = $this->getMockBuilder(\Article\Filter\ArticleFilter::class)
            ->getMockForAbstractClass();
        $postFilter = $this->getMockBuilder(\Article\Filter\PostFilter::class)
            ->getMockForAbstractClass();
        $categoryMapper = $this->getMockBuilder(\Category\Mapper\CategoryMapper::class)
            ->getMockForAbstractClass();
        $adminUsersMapper = $this->getMockBuilder(\Admin\Mapper\AdminUsersMapper::class)
            ->getMockForAbstractClass();

        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue(['upload' => ['public_path' => 'test', 'non_public_path' => 'test']]));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($articleMapper));
        $container->expects(static::at(2))
            ->method('get')
            ->will(static::returnValue($articlePostMapper));
        $container->expects(static::at(3))
            ->method('get')
            ->will(static::returnValue($articleFilter));
        $container->expects(static::at(4))
            ->method('get')
            ->will(static::returnValue($postFilter));
        $container->expects(static::at(5))
            ->method('get')
            ->will(static::returnValue($categoryMapper));
        $container->expects(static::at(6))
            ->method('get')
            ->will(static::returnValue($adminUsersMapper));
        $factory = new \Article\Factory\Service\PostServiceFactory();
        static::assertInstanceOf(\Article\Service\PostService::class, $factory($container));
    }
}
