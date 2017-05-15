<?php

declare(strict_types=1);

namespace Article\Mapper;

use Article\Entity\ArticleType;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;

/**
 * Class ArticleEventsMapper.
 *
 * @package Core\Mapper
 */
class ArticleEventsMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    /**
     * @var string
     */
    protected $table = 'article_events';

    /**
     * Db adapter setter method,
     *
     * @param  Adapter $adapter db adapter
     * @return void
     */
    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getPaginationSelect($status = null)
    {
        $select = $this->getSql()->select()
            ->columns(['title', 'body', 'longitude', 'latitude'])
            ->join('articles', 'article_events.article_uuid = articles.article_uuid')
            ->join('admin_users', 'admin_users.admin_user_uuid = articles.admin_user_uuid', ['admin_user_id', 'first_name', 'last_name'])
            ->where(['articles.type' => ArticleType::EVENT])
            ->order(['created_at' => 'desc']);

        if($status) {
            $select->where(['articles.status' => (int)$status]);
        }

        return $select;
    }

    public function get($id)
    {
        $select = $this->getSql()->select()
            ->join('articles', 'article_events.article_uuid = articles.article_uuid')
            ->where(['articles.article_id' => $id]);

        return $this->selectWith($select)->current();
    }

    public function getLatest($limit = 50)
    {
        $select = $this->getSql()->select()
            ->join('articles', 'article_events.article_uuid = articles.article_uuid', ['article_id', 'slug', 'published_at'])
            ->where(['articles.status' => 1])
            ->order(['published_at' => 'desc'])
            ->limit($limit);

        return $this->selectWith($select);
    }
}
