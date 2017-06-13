<?php
declare(strict_types = 1);
namespace Test\Admin\Factory\Controller;

class ArticleFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testArticleFactoryShouldCreateExpectedArticleControllerInstance()
    {
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->getMockForAbstractClass();
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $articleRepo = $this->getMockBuilder('Admin\Model\Repository\ArticleRepositoryInterface')
            ->getMockForAbstractClass();
        $session = new \Zend\Session\SessionManager();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($template));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($articleRepo));
        $container->expects(static::at(2))
            ->method('get')
            ->will(static::returnValue($session));
        $container->expects(static::at(3))
            ->method('get')
            ->will(static::returnValue($router));

        $articleFactory = new \Admin\Factory\Controller\ArticleFactory();
        static::assertInstanceOf(\Admin\Controller\ArticleController::class, $articleFactory($container));
    }
}
