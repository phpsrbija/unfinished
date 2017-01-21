<?php
declare(strict_types = 1);

namespace Test\Admin\Model\Entity;

class ArticleRepository /*Test*/ extends \PHPUnit_Framework_TestCase
{
//    public function testFetchAllArticlesShouldReturnResultSet()
//    {
//        $storage = $this->getMockBuilder('Admin\Mapper\ArticleMapper')
//            ->disableOriginalConstructor()
//            ->setMethods(['fetchAll'])
//            ->getMock();
//        $storage->expects(self::once())
//            ->method('fetchAll')
//            ->willReturn(new \Zend\Db\ResultSet\HydratingResultSet());
//
//        $articleRepo = new \Admin\Model\Repository\ArticleRepository($storage, new \DateTime(), new \Admin\Validator\ArticleValidator());
//        $result = $articleRepo->fetchAllArticles();
//
//        self::assertInstanceOf('Zend\Db\ResultSet\HydratingResultSet', $result);
//    }
//
//    public function testFetchSingleArticleShouldReturnArticleData()
//    {
//        $articleData = array(
//            'test' => 'test'
//        );
//        $storage = $this->getMockBuilder('Admin\Mapper\ArticleMapper')
//            ->disableOriginalConstructor()
//            ->setMethods(['fetchOne'])
//            ->getMock();
//        $storage->expects(self::once())
//            ->method('fetchOne')
//            ->willReturn($articleData);
//
//        $articleRepo = new \Admin\Model\Repository\ArticleRepository($storage, new \DateTime(), new \Admin\Validator\ArticleValidator());
//        $result = $articleRepo->fetchSingleArticle('123');
//
//        self::assertSame($articleData, $result);
//    }
//
//    public function testCreateArticleShouldReturnTrue()
//    {
//        $request = $this->getMockBuilder('Psr\Http\Message\ServerRequestInterface')
//            ->disableOriginalConstructor()
//            ->setMethods(['getParsedBody'])
//            ->getMockForAbstractClass();
//        $request->expects(static::exactly(2))
//            ->method('getParsedBody')
//            ->willReturn(['title' => 'data', 'lead' => 'lead', 'body' => 'test']);
//
//        $storage = $this->getMockBuilder('Admin\Mapper\ArticleMapper')
//            ->disableOriginalConstructor()
//            ->setMethods(['create'])
//            ->getMock();
//        $storage->expects(self::once())
//            ->method('create')
//            ->willReturn(true);
//
//        $articleRepo = new \Admin\Model\Repository\ArticleRepository($storage, new \DateTime(), new \Admin\Validator\ArticleValidator());
//
//        self::assertSame(true, $articleRepo->createArticle($request, 'test'));
//    }
//
//    public function testUpdateArticleShouldReturnTrue()
//    {
//        $request = $this->getMockBuilder('Psr\Http\Message\ServerRequestInterface')
//            ->disableOriginalConstructor()
//            ->setMethods(['getParsedBody'])
//            ->getMockForAbstractClass();
//        $request->expects(static::exactly(2))
//            ->method('getParsedBody')
//            ->willReturn(['title' => 'data', 'lead' => 'lead', 'body' => 'test', 'article_uuid' => 'test']);
//        $storage = $this->getMockBuilder('Admin\Mapper\ArticleMapper')
//            ->disableOriginalConstructor()
//            ->setMethods(['update'])
//            ->getMock();
//        $storage->expects(self::once())
//            ->method('update')
//            ->willReturn(true);
//
//        $articleRepo = new \Admin\Model\Repository\ArticleRepository($storage, new \DateTime(), new \Admin\Validator\ArticleValidator());
//
//        self::assertSame(true, $articleRepo->updateArticle($request, 'test'));
//    }
//
//    public function testDeleteArticleShouldReturnTrue()
//    {
//        $storage = $this->getMockBuilder('Admin\Mapper\ArticleMapper')
//            ->disableOriginalConstructor()
//            ->setMethods(['delete'])
//            ->getMock();
//        $storage->expects(self::once())
//            ->method('delete')
//            ->willReturn(true);
//
//        $articleRepo = new \Admin\Model\Repository\ArticleRepository($storage, new \DateTime(), new \Admin\Validator\ArticleValidator());
//
//        self::assertSame(true, $articleRepo->deleteArticle('test'));
//    }
}
