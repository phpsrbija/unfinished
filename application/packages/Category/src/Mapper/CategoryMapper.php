<?php

declare(strict_types = 1);

namespace Category\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Expression;
use Article\Entity\ArticleType;

/**
 * Class CategoryMapper.
 *
 * @package Category\Mapper
 */
class CategoryMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    /** @var string */
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

    public function getCategoryPostsSelect($categoryId = null, $limit = null)
    {
        $select = $this->getSql()->select()
            ->columns(['category_name' => 'name', 'category_slug' => 'slug'])
            ->join('articles', 'articles.category_uuid = category.category_uuid',
                ['article_id', 'slug', 'admin_user_uuid', 'published_at']
            )->join('article_posts', 'article_posts.article_uuid = articles.article_uuid', ['*'], 'right')
            ->join('admin_users', 'admin_users.admin_user_uuid = articles.admin_user_uuid',
                ['admin_user_id', 'first_name', 'last_name', 'face_img']
            )->where(['articles.status' => 1])
            ->order(['published_at' => 'desc']);

        if ($categoryId) {
            $select->where(['category_id' => $categoryId]);
        }

        if ($limit) {
            $select->limit($limit);
        }

        return $select;
    }


    /**
     * Return only category with type = Post
     *
     * @param int $limit
     * @param null $order
     * @param null $inHomepage
     * @param null $inCategoryList
     *
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getWeb(
        $limit = 7,
        $order = null,
        $inHomepage = null,
        $inCategoryList = null
    ) {
        $select = $this->getSql()->select()->where(['type' => ArticleType::POST]);

        if ($inHomepage !== null) {
            $select->where(['is_in_homepage' => $inHomepage]);
        }

        if ($inCategoryList !== null) {
            $select->where(['is_in_category_list' => $inCategoryList]);
        }

        if ($limit) {
            $select->limit($limit);
        }

        if ($order) {
            $select->order($order);
        } else {
            $select->order(new Expression('rand()'));
        }

        return $this->selectWith($select);
    }
}
