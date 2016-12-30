<?php
declare(strict_types = 1);
namespace Core\Mapper;

use Core\Entity\ArticleType;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\TableGateway\AbstractTableGateway;

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

    public function getPostsSelect()
    {
        return $this->getSql()->select()
            ->where(['articles.type' => ArticleType::POST])
            ->join('article_posts', 'article_posts.article_uuid = articles.article_uuid', ['title', 'body', 'lead'])
            ->order(['created_at' => 'desc']);
    }

    public function getPost($id)
    {
        $select = $this->getSql()->select()
            ->where(['article_id' => $id])
            ->join('article_posts', 'article_posts.article_uuid = articles.article_uuid', ['title', 'body', 'lead']);

        return $this->selectWith($select)->current();
    }

    public function create($articleData)
    {
        $this->insert($articleData);
    }

}
