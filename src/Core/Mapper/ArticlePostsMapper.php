<?php
declare(strict_types = 1);
namespace Core\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;
use Core\Entity\ArticleType;

/**
 * Class ArticlePostsMapper.
 *
 * @package Core\Mapper
 */
class ArticlePostsMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    /**
     * @var string
     */
    protected $table = 'article_posts';

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
            ->columns(['title', 'body', 'lead'])
            ->join('articles', 'article_posts.article_uuid = articles.article_uuid')
            ->where(['articles.type' => ArticleType::POST])
            ->order(['created_at' => 'desc']);
    }

    public function get($id)
    {
        $select = $this->getSql()->select()
            ->columns(['title', 'body', 'lead'])
            ->join('articles', 'article_posts.article_uuid = articles.article_uuid')
            ->where(['articles.article_id' => $id]);

        return $this->selectWith($select)->current();
    }

    public function getTages($articleId)
    {
        $select = $this->getSql()->select()
            ->columns([])
            ->join('articles', 'article_posts.article_uuid = articles.article_uuid')
            ->join('article_tags', 'article_posts.article_uuid = article_tags.article_uuid')
            ->join('tags', 'article_tags.tag_uuid = tags.tag_uuid', ['name', 'slug', 'tag_id'])
            ->where(['articles.article_id' => $articleId]);

        return $this->selectWith($select);
    }

}
