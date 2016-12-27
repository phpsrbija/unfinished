<?php
namespace Admin\Model\Repository;

use Admin\Mapper\ArticleMapper;
use Admin\Validator\ArticleValidator as Validator;
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
    private $articleStorage;

    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * ArticleRepository constructor.
     *
     * @param ArticleMapper $articleStorage
     * @param \DateTime $dateTime
     */
    public function __construct(ArticleMapper $articleStorage, \DateTime $dateTime, Validator $validator)
    {
        $this->articleStorage = $articleStorage;
        $this->dateTime       = $dateTime;
        $this->validator      = $validator;
    }

    /**
     * @param array $params
     * @return ResultSet
     */
    public function fetchAllArticles($page, $limit)
    {
        $select           = $this->articleStorage->getPaginationSelect();
        $paginatorAdapter = new DbSelect($select, $this->articleStorage->getAdapter());
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
        return $this->articleStorage->fetchOne($articleId);
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
            return $this->articleStorage->update($data, ['article_id' => $id]);
        }
        else{
            $data['article_id']      = Uuid::uuid1()->toString();
            $data['article_uuid'] = (new MysqlUuid($data['article_id']))->toFormat(new Binary);

            return $this->articleStorage->insert($data);
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
        return $this->articleStorage->delete(['article_id' => $id]);
    }

}
