<?php
declare(strict_types = 1);

namespace Test\Admin\Model\Entity;

class ArticleRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFetchAllArticlesShouldReturnResultSet()
    {
        $storage = $this->getMockBuilder('Admin\Db\ArticleTableGateway')
            ->disableOriginalConstructor()
            ->setMethods(['fetchAll'])
            ->getMock();
        $storage->expects(self::once())
            ->method('fetchAll')
            ->willReturn(new \Zend\Db\ResultSet\HydratingResultSet());

        $articleRepo = new \Admin\Model\Repository\ArticleRepository($storage, new \DateTime());
        $result = $articleRepo->fetchAllArticles();

        self::assertInstanceOf('Zend\Db\ResultSet\HydratingResultSet', $result);
    }

    public function testFetchSingleArticleShouldReturnArticleEntity()
    {
        $storage = $this->getMockBuilder('Admin\Db\ArticleTableGateway')
            ->disableOriginalConstructor()
            ->setMethods(['fetchOne'])
            ->getMock();
        $storage->expects(self::once())
            ->method('fetchOne')
            ->willReturn(new \Admin\Model\Entity\ArticleEntity());

        $articleRepo = new \Admin\Model\Repository\ArticleRepository($storage, new \DateTime());
        $result = $articleRepo->fetchSingleArticle('123');

        self::assertInstanceOf('Admin\Model\Entity\ArticleEntity', $result);
    }

    public function testCreateArticleShouldReturnTrue()
    {
        $storage = $this->getMockBuilder('Admin\Db\ArticleTableGateway')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $storage->expects(self::once())
            ->method('create')
            ->willReturn(true);

        $article = new \Admin\Model\Entity\ArticleEntity();
        $articleRepo = new \Admin\Model\Repository\ArticleRepository($storage, new \DateTime());

        self::assertSame(true, $articleRepo->createArticle($article));
    }

    public function testUpdateArticleShouldReturnTrue()
    {
        $storage = $this->getMockBuilder('Admin\Db\ArticleTableGateway')
            ->disableOriginalConstructor()
            ->setMethods(['update'])
            ->getMock();
        $storage->expects(self::once())
            ->method('update')
            ->willReturn(true);

        $article = new \Admin\Model\Entity\ArticleEntity();
        $articleRepo = new \Admin\Model\Repository\ArticleRepository($storage, new \DateTime());

        self::assertSame(true, $articleRepo->updateArticle($article));
    }

    public function testDeleteArticleShouldReturnTrue()
    {
        $storage = $this->getMockBuilder('Admin\Db\ArticleTableGateway')
            ->disableOriginalConstructor()
            ->setMethods(['delete'])
            ->getMock();
        $storage->expects(self::once())
            ->method('delete')
            ->willReturn(true);

        $article = new \Admin\Model\Entity\ArticleEntity();
        $articleRepo = new \Admin\Model\Repository\ArticleRepository($storage, new \DateTime());

        self::assertSame(true, $articleRepo->deleteArticle($article));
    }
}
