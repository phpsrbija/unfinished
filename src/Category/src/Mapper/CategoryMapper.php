<?php

declare(strict_types=1);

namespace Category\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Expression;

/**
 * Class CategoryMapper.
 *
 * @package Core\Mapper
 */
class CategoryMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    /**
     * @var string
     */
    protected $table = 'category';

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

    public function get($id)
    {
        return $this->select(['category_id' => $id])->current();
    }

    public function getPaginationSelect()
    {
        $select = $this->getSql()->select()->order(['name' => 'asc']);

        return $select;
    }

    public function getCategoryPostsSelect($categoryId, $limit = null)
    {
        $select = $this->getSql()->select()
            ->columns([])
            ->join('article_categories', 'article_categories.category_uuid = category.category_uuid', [])
            ->join('articles', 'articles.article_uuid = article_categories.article_uuid', ['article_id', 'slug', 'admin_user_uuid', 'published_at'])
            ->join('article_posts', 'article_posts.article_uuid = articles.article_uuid', ['*'], 'right')
            ->join('admin_users', 'admin_users.admin_user_uuid = articles.admin_user_uuid', ['admin_user_id', 'first_name', 'last_name'])
            ->where(['category_id' => $categoryId])
            ->where(['articles.status' => 1])
            ->order(['published_at' => 'desc']);

        if($limit) {
            $select->limit($limit);
        }

        return $select;
    }

    /**
     * @todo Refactor and add TYPE into the category table. Than fetch only for blog_post type..
     */
    public function getWeb($limit = 7)
    {
        $select = $this->getSql()->select()->limit($limit);
        $select->where->notEqualTo('slug', 'php-videos');
        $select->where->notEqualTo('slug', 'events');
        $select->order(new Expression('rand()'));

        return $this->selectWith($select);
    }
}
