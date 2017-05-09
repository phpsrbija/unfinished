<?php

declare(strict_types=1);

namespace Category\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;

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

    public function getCategoryPostsSelect($categoryId)
    {
        $select = $this->getSql()->select()
            ->columns([])
            ->join('article_categories', 'article_categories.category_uuid = category.category_uuid', [])
            ->join('articles', 'articles.article_uuid = article_categories.article_uuid', '*')
            ->where(['category_id' => $categoryId]);

        return $select;
    }
}
