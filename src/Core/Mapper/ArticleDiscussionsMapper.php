<?php

declare(strict_types = 1);

namespace Core\Mapper;

use Core\Entity\ArticleType;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;

class ArticleDiscussionsMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    protected $table = 'article_discussions';

    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getPaginationSelect()
    {
        return $this->getSql()->select()
            ->columns(['title', 'body'])
            ->join('articles', 'article_discussions.article_uuid = articles.article_uuid')
            ->where(['articles.type' => ArticleType::DISCUSSION])
            ->order(['created_at' => 'desc']);
    }

    public function get($id)
    {
        $select = $this->getSql()->select()
            ->columns(['title', 'body'])
            ->join('articles', 'article_discussions.article_uuid = articles.article_uuid')
            ->join('article_tags', 'article_discussions.article_uuid = article_tags.article_uuid')
            ->join('tags', 'article_tags.tag_uuid = tags.tag_uuid')
            ->where(['articles.article_id' => $id]);

        return $this->selectWith($select);
    }

}
