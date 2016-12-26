<?php
namespace Admin\Model\Repository;

use Admin\Mapper\ArticleMapper;
use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
use Psr\Http\Message\ServerRequestInterface as Request;
use Admin\Validator\ArticleValidator as Validator;
use Zend\Db\ResultSet\HydratingResultSet as ResultSet;

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
    public function fetchAllArticles($params = [])
    {
        return $this->articleStorage->fetchAll($params);
    }

    /**
     * @param string $articleUuid
     * @return array
     */
    public function fetchSingleArticle($articleUuid)
    {
        return $this->articleStorage->fetchOne($articleUuid);
    }

    /**
     * Saves article to repository.
     *
     * @param Request $request
     * @param string $adminUserUuid
     * @return bool
     */
    public function createArticle(Request $request, $adminUserUuid)
    {
        if(count($request->getParsedBody())){
            $data['data']                 = $request->getParsedBody();
            $data['data']['created_at']   = $this->dateTime->format('Y-m-d H:i:s');
            $data['data']['article_id']   = Uuid::uuid1()->toString();
            $data['data']['article_uuid'] = (new MysqlUuid($data['data']['article_id']))->toFormat(new Binary);
            $data['user_uuid']            = $adminUserUuid;
            $this->validator->validate($data['data']);

            return $this->articleStorage->create($data['data']);
        }

        return false;
    }

    /**
     * Update article to repository.
     *
     * @param Request $request
     * @param string $adminUserUuid
     * @return bool
     */
    public function updateArticle(Request $request, $adminUserUuid)
    {
        if(count($request->getParsedBody())){
            $data['data']      = $request->getParsedBody();
            $data['user_uuid'] = $adminUserUuid;
            $this->validator->validate($data['data']);

            return $this->articleStorage->update($data['data'], ['article_uuid' => $data['data']['article_uuid']]);
        }

        return false;
    }

    /**
     * Delete an article.
     *
     * @param string $id
     * @return bool
     */
    public function deleteArticle($id)
    {
        return $this->articleStorage->delete(['article_uuid' => $id]);
    }

}
