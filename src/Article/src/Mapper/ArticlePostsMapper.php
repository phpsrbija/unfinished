<?php
declare(strict_types=1);

namespace Article\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;
use Article\Entity\ArticleType;

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
            ->columns(['title', 'body', 'lead', 'featured_img', 'main_img', 'is_homepage'])
            ->join('articles', 'article_posts.article_uuid = articles.article_uuid')
            ->where(['articles.type' => ArticleType::POST])
            ->order(['created_at' => 'desc']);
    }

    public function get($id)
    {
        $select = $this->getSql()->select()
            ->columns(['title', 'body', 'lead', 'featured_img', 'main_img', 'has_layout', 'is_homepage'])
            ->join('articles', 'article_posts.article_uuid = articles.article_uuid')
            ->where(['articles.article_id' => $id]);

        return $this->selectWith($select)->current();
    }

    public function getHomepage()
    {
        $select = $this->getSql()->select()
            ->join('articles', 'article_posts.article_uuid = articles.article_uuid')
            ->where(['article_posts.is_homepage' => true, 'articles.status' => 1]);

        return $this->selectWith($select)->current();
    }

    public function getBySlug($slug)
    {
        $select = $this->getSql()->select()
            ->columns(['title', 'body', 'lead', 'featured_img', 'main_img'])
            ->join('articles', 'article_posts.article_uuid = articles.article_uuid')
            ->where(['articles.slug' => $slug]);

        return $this->selectWith($select)->current();
    }

    public function getAll()
    {
        $select = $this->getSql()->select()
            ->join('articles', 'article_posts.article_uuid = articles.article_uuid', ['article_id']);

        return $this->selectWith($select);
    }

}
