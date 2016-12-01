<?php

namespace Admin\Db;

use Admin\Model\Entity\ArticleEntity;
use Admin\Model\Storage\ArticleStorageInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSetInterface;

class ArticleTableGateway extends TableGateway implements ArticleStorageInterface
{
    protected $columns = array(
        'articleUuid' => 'article_uuid',
        'title' => 'title',
        'publishedAt' => 'published_at',
//        'createdAt' => 'created_at',
        'slug' => 'slug',
        'type' => 'type',
    );

    /**
     * @param AdapterInterface   $adapter
     * @param ResultSetInterface $resultSet
     */
    public function __construct(AdapterInterface $adapter, ResultSetInterface $resultSet)
    {
        parent::__construct('articles', $adapter, null, $resultSet);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAll($params)
    {
        $select = $this->getSql()->select();

        return $this->selectWith($select);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchOne($params)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('article_uuid', $params['article_uuid']);
        $select->limit(1);

        return $this->selectWith($select);
    }

    /**
     * {@inheritDoc}
     */
    public function create(ArticleEntity $article)
    {
        $insertData = $article->getArrayCopy();

        $insert = $this->getSql()->insert();
        $insert->values($insertData);

        return $this->insertWith($insert) > 0;
    }

    /**
     * {@inheritDoc}
     */
    public function update($article, $where = null, array $joins = null)
    {
        $updateData = $article->getArrayCopy();

        $update = $this->getSql()->update();
        $update->set($updateData);
        $update->where->equalTo('article_uuid', $article->getArticle_uuid());

        return $this->updateWith($update) > 0;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($params)
    {
        $delete = $this->getSql()->delete();
        $delete->where->equalTo('article_uuid', $params['article_uuid']);

        return $this->deleteWith($delete) > 0;
    }
}