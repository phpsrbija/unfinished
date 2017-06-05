<?php

declare(strict_types=1);

namespace Article\Mapper;

use Article\Entity\ArticleType;
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
            ->join('category', 'category.category_uuid = articles.category_uuid',
                ['category_slug' => 'slug', 'category_name' => 'name', 'category_id'], 'left')
            ->join('admin_users', 'admin_users.admin_user_uuid = articles.admin_user_uuid', ['admin_user_id'], 'left')
            ->where(['articles.article_id' => $id]);

        return $this->selectWith($select)->current();
    }

}
