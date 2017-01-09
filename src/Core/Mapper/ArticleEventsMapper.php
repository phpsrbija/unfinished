<?php

declare(strict_types = 1);

namespace Core\Mapper;

use Core\Entity\ArticleType;
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

    public function getPaginationSelect()
    {
        return $this->getSql()->select()
            ->columns(['title', 'body', 'longitude', 'latitude'])
            ->join('articles', 'article_events.article_uuid = articles.article_uuid')
            ->where(['articles.type' => ArticleType::EVENT])
            ->order(['created_at' => 'desc']);
    }

    public function get($id)
    {
        $select = $this->getSql()->select()
            ->columns(['title', 'body', 'longitude', 'latitude'])
            ->join('articles', 'article_events.article_uuid = articles.article_uuid')
            ->where(['articles.article_id' => $id]);

        return $this->selectWith($select)->current();
    }
}
