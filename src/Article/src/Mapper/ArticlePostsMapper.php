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
            ->join('category', 'articles.category_uuid = category.category_uuid', ['category_name' => 'name'], 'left')
            ->where(['articles.type' => ArticleType::POST])
            ->order(['created_at' => 'desc']);
    }

    public function get($id)
    {
        $select = $this->getSql()->select()
            ->columns(['title', 'body', 'lead', 'featured_img', 'main_img', 'has_layout', 'is_homepage'])
            ->join('articles', 'article_posts.article_uuid = articles.article_uuid')
            ->join('category', 'category.category_uuid = articles.category_uuid',
                ['category_slug' => 'slug', 'category_name' => 'name', 'category_id'], 'left')
            ->join('admin_users', 'admin_users.admin_user_uuid = articles.admin_user_uuid', ['admin_user_id'], 'left')
            ->where(['articles.article_id' => $id]);

        return $this->selectWith($select)->current();
    }

    public function getNear($publishedAt, $direction)
    {
        $select = $this->getSql()->select()
            ->join('articles', 'article_posts.article_uuid = articles.article_uuid')
            ->join('category', 'category.category_uuid = articles.category_uuid', ['category_slug' => 'slug'])
            ->where(['articles.status' => 1])
            ->limit(1);

        if($direction > 0) {
            $select->where->greaterThan('published_at', $publishedAt);
            $select->order(['published_at' => 'asc']);
        } elseif($direction < 0) {
            $select->where->lessThan('published_at', $publishedAt);
            $select->order(['published_at' => 'desc']);
        }

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
            ->join('category', 'category.category_uuid = articles.category_uuid', ['category_name' => 'name', 'category_slug' => 'slug'])
            ->join('admin_users', 'admin_users.admin_user_uuid = articles.admin_user_uuid', ['first_name', 'last_name'])
            ->where(['articles.slug' => $slug, 'articles.status' => 1]);

        return $this->selectWith($select)->current();
    }

    public function getAll()
    {
        $select = $this->getSql()->select()
            ->join('articles', 'article_posts.article_uuid = articles.article_uuid', ['article_id', 'slug']);

        return $this->selectWith($select);
    }

    public function getLatest($limit = 10)
    {
        $select = $this->getSql()->select()
            ->join('articles', 'article_posts.article_uuid = articles.article_uuid')
            ->join('admin_users', 'admin_users.admin_user_uuid = articles.admin_user_uuid', ['first_name', 'last_name'])
            ->join('category', 'category.category_uuid = articles.category_uuid',
                ['category_name' => 'name', 'category_id', 'category_slug' => 'slug'])
            ->where(['articles.status' => 1])
            ->order(['articles.published_at' => 'desc'])
            ->limit($limit);

        return $this->selectWith($select);
    }

}
