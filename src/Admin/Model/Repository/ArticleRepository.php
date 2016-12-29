<?php
namespace Admin\Model\Repository;

use Core\Mapper\ArticleMapper;
use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Db\ResultSet\HydratingResultSet as ResultSet;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @var ArticleMapper
     */
    private $articleMapper;

    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * ArticleRepository constructor.
     *
     * @param ArticleMapper $articleStorage
     * @param \DateTime $dateTime
     */
    public function __construct(ArticleMapper $articleMapper, \DateTime $dateTime)
    {
        $this->articleMapper = $articleMapper;
        $this->dateTime      = $dateTime;
    }

    /**
     * @param array $params
     * @return ResultSet
     */
    public function fetchAllArticles($page, $limit)
    {
        $select           = $this->articleMapper->getPaginationSelect();
        $paginatorAdapter = new DbSelect($select, $this->articleMapper->getAdapter());
        $paginator        = new Paginator($paginatorAdapter);

        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($limit);

        return $paginator;
    }

    /**
     * @param string $articleId
     * @return array
     */
    public function fetchSingleArticle($articleId)
    {
        return $this->articleMapper->fetchOne($articleId);
    }

    /**
     * Update article to repository.
     *
     * @param Request $request
     * @param string $adminUserUuid
     * @return bool
     */
    public function saveArticle($user, $data, $id = null)
    {
        $data['admin_user_uuid'] = $user->admin_user_uuid;

        if($id){
            return $this->articleMapper->update($data, ['article_id' => $id]);
        }
        else{
            $data['article_id']   = Uuid::uuid1()->toString();
            $data['article_uuid'] = (new MysqlUuid($data['article_id']))->toFormat(new Binary);

            return $this->articleMapper->insert($data);
        }
    }

    /**
     * Delete an article.
     *
     * @param string $id
     * @return bool
     */
    public function deleteArticle($id)
    {
        return $this->articleMapper->delete(['article_id' => $id]);
    }

}
