<?php
declare(strict_types = 1);

namespace Test\Admin\Db;

use Admin\Model\Entity\ArticleEntity;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Hydrator\ArraySerializable;
use Admin\Db\ArticleTableGateway;

//class ArticleTableGatewayTest extends \PHPUnit_Framework_TestCase
//{
//    public function testFetchAllShouldReturnResult()
//    {
//        $resultSetPrototype = new HydratingResultSet(
//            new ArraySerializable(),
//            new ArticleEntity()
//        );
//        $articleRepo = $this->getMockBuilder('Zend\Db\Adapter\AdapterInterface')
//            ->getMockForAbstractClass();
//
//        $gateway = new ArticleTableGateway(
//            $articleRepo,
//            $resultSetPrototype
//        );
//        var_dump($gateway->fetchAll([]));
//    }

//    public function testFetchOneShouldReturnResult()
//    {
//        $resultSetPrototype = new HydratingResultSet(
//            new ArraySerializable(),
//            new ArticleEntity()
//        );
//        $adapter = $this->getMockBuilder('Zend\Db\Adapter\AdapterInterface')
//            ->getMockForAbstractClass();
//        $sql = $this->getMockBuilder('Zend\Db\Sql\Sql')
//            ->disableOriginalConstructor()
//            ->getMockForAbstractClass();
//
//        $sql = new \Zend\Db\Sql\Sql($adapter);
//
//        $gateway = new ArticleTableGateway(
//            $adapter,
//            $resultSetPrototype,
//            null,
//            $sql
//        );
//        var_dump($gateway->fetchOne(['article_uuid' => '123']));
//    }

//}