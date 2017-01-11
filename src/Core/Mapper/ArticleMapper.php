<?php
declare(strict_types = 1);
namespace Core\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\ResultSet\ResultSetInterface;
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

    /**
     * Return all tags for given article
     */
    public function getTages($articleId)
    {
        $select = $this->getSql()->select()
            ->columns([])
            ->join('article_tags', 'articles.article_uuid = article_tags.article_uuid')
            ->join('tags', 'article_tags.tag_uuid = tags.tag_uuid', ['name', 'slug', 'tag_id'])
            ->where(['articles.article_id' => $articleId]);

        return $this->selectWith($select);
    }

    /**
     * Delete all tags for given article
     */
    public function deleteTags($id)
    {
        $platform    = $this->getAdapter()->getPlatform();
        $adapter     = $this->getAdapter();
        $deleteQuery = (new Delete('article_tags'))->where(['article_uuid' => $id]);

        return $adapter->query($deleteQuery->getSqlString($platform))->execute();
    }

    /**
     * @todo Refactore it to do a multi insert into MySQL
     */
    public function insertTags($tags, $articleId)
    {
        $platform = $this->getAdapter()->getPlatform();
        $adapter  = $this->getAdapter();

        foreach($tags as $tag){
            $insertQuery = (new Insert('article_tags'))->values([
                'article_uuid' => $articleId,
                'tag_uuid'     => $tag->tag_uuid
            ]);

            $adapter->query($insertQuery->getSqlString($platform))->execute();
        }
    }

}
