<?php

declare(strict_types=1);

namespace Article\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;
use Zend\Db\TableGateway\AbstractTableGateway;

/**
 * Class ArticleMapper.
 */
class ArticleMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    /**
     * @var string
     */
    protected $table = 'articles';

    /**
     * Db adapter setter method,.
     *
     * @param Adapter $adapter db adapter
     *
     * @return void
     */
    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function fetchAll($params)
    {
        return $this->select($params);
    }

    public function create($articleData)
    {
        $this->insert($articleData);
    }

    public function getCategories($articleId)
    {
        $select = $this->getSql()->select()
            ->columns([])
            ->join('category', 'category.category_uuid = articles.category_uuid', ['name', 'slug', 'category_id'])
            ->where(['articles.article_id' => $articleId]);

        return $this->selectWith($select);
    }

    /**
     * Delete all categories for given article.
     */
    public function deleteCategories($id)
    {
        trigger_error('Do not use anymore 01!', E_USER_NOTICE);
    }

    /**
     * @todo Refactore it - do a multi insert into MySQL
     */
    public function insertCategories($categories, $articleId)
    {
        trigger_error('Do not use anymore 02!', E_USER_NOTICE);
    }
}
