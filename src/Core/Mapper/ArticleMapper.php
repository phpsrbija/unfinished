<?php
declare(strict_types=1);

namespace Core\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;

/**
 * Class ArticleMapper.
 *
 * @package Core\Mapper
 */
class ArticleMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    /**
     * @var string
     */
    protected $table = 'articles';

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
            ->join('article_categories', 'articles.article_uuid = article_categories.article_uuid')
            ->join('category', 'article_categories.category_uuid = category.category_uuid', ['name', 'slug', 'category_id'])
            ->where(['articles.article_id' => $articleId]);

        return $this->selectWith($select);
    }

    /**
     * Delete all categories for given article
     */
    public function deleteCategories($id)
    {
        $platform    = $this->getAdapter()->getPlatform();
        $adapter     = $this->getAdapter();
        $deleteQuery = (new Delete('article_categories'))->where(['article_uuid' => $id]);

        return $adapter->query($deleteQuery->getSqlString($platform))->execute();
    }

    /**
     * @todo Refactore it - do a multi insert into MySQL
     */
    public function insertCategories($categories, $articleId)
    {
        $platform = $this->getAdapter()->getPlatform();
        $adapter  = $this->getAdapter();

        foreach($categories as $category) {
            $insertQuery = (new Insert('article_categories'))->values([
                'article_uuid'  => $articleId,
                'category_uuid' => $category->category_uuid
            ]);

            $adapter->query($insertQuery->getSqlString($platform))->execute();
        }
    }

}
