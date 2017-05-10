<?php
declare(strict_types=1);

namespace Article\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;
use Article\Entity\ArticleType;

/**
 * Class ArticleVideosMapper.
 *
 * @package Core\Mapper
 */
class ArticleVideosMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    /**
     * @var string
     */
    protected $table = 'article_videos';

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

    public function getPaginationSelect($isActive = null)
    {
        $select = $this->getSql()->select()
            ->columns(['title', 'body', 'lead'])
            ->join('articles', 'article_videos.article_uuid = articles.article_uuid')
            ->join('admin_users', 'admin_users.admin_user_uuid = articles.admin_user_uuid', ['admin_user_id', 'first_name', 'last_name'])
            ->where(['articles.type' => ArticleType::POST])
            ->order(['created_at' => 'desc']);

        if($isActive !== null) {
            $select->where(['articles.status' => (int)$isActive]);
        }

        return $select;
    }

    public function get($id)
    {
        $select = $this->getSql()->select()
            ->columns(['title', 'body', 'lead', 'featured_img', 'main_img', 'embed_code'])
            ->join('articles', 'article_videos.article_uuid = articles.article_uuid')
            ->where(['articles.article_id' => $id]);

        return $this->selectWith($select)->current();
    }

}
