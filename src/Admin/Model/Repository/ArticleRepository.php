<?php
namespace Admin\Model\Repository;

use Admin\Model\Entity\ArticleEntity;
use Admin\Model\Storage\ArticleStorageInterface;
use Ramsey\Uuid\Uuid;
use Psr\Http\Message\ServerRequestInterface as Request;
use Admin\Validator\ArticleValidator as Validator;


class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @var ArticleStorageInterface
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
     * @param ArticleStorageInterface $articleStorage
     * @param \DateTime               $dateTime
     */
    public function __construct(ArticleStorageInterface $articleStorage, \DateTime $dateTime, Validator $validator)
    {
        $this->articleStorage = $articleStorage;
        $this->dateTime = $dateTime;
        $this->validator = $validator;
    }

    /**
     * @param array $params
     *
     * @return \Zend\Db\ResultSet\ResultSetInterface
     */
    public function fetchAllArticles($params = array()) : \Zend\Db\ResultSet\ResultSetInterface
    {
        return $this->articleStorage->fetchAll($params);
    }

    /**
     * @param string $articleUuid
     * @return ArticleEntity
     */
    public function fetchSingleArticle($articleUuid) : ArticleEntity
    {
        return $this->articleStorage->fetchOne($articleUuid);
    }

    /**
     * Saves article to repository.
     *
     * @param Request $request
     * @param string  $adminUserUuid
     *
     * @return bool
     */
    public function createArticle(Request $request, $adminUserUuid)
    {
        if (count($request->getParsedBody())) {
            $article = new \Admin\Model\Entity\ArticleEntity();
            $data['data'] = $request->getParsedBody();
            $data['data']['created_at'] = $this->dateTime->format('Y-m-d H:i:s');
            $data['data']['article_uuid'] = Uuid::uuid1()->toString();
            $data['user_uuid'] = $adminUserUuid;
            $this->validator->validate($data['data']);
            $article->exchangeArray($data['data']);

            return $this->articleStorage->create($article);
        }

        return false;
    }

    /**
     *
     * @param ArticleEntity $article
     *
     * @return bool
     */
    public function updateArticle(ArticleEntity $article)
    {
        return $this->articleStorage->update($article);
    }

    /**
     * Delete an article.
     *
     * @param ArticleEntity $article
     * @return bool
     */
    public function deleteArticle(ArticleEntity $article)
    {
        return $this->articleStorage->delete(['article_uuid' => $article->getArticle_uuid()]);
    }

}
