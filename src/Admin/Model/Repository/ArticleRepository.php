<?php
namespace Admin\Model\Repository;

use Admin\Model\Entity\ArticleEntity;
use Admin\Model\Storage\ArticleStorageInterface;

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
     * ArticleRepository constructor.
     *
     * @param ArticleStorageInterface $articleStorage
     * @param \DateTime               $dateTime
     */
    public function __construct(ArticleStorageInterface $articleStorage, \DateTime $dateTime)
    {
        $this->articleStorage = $articleStorage;
        $this->dateTime = $dateTime;
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
     * @param ArticleEntity $article
     *
     * @return bool
     */
    public function createArticle(ArticleEntity $article)
    {
            return $this->articleStorage->create($article);
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

    public function deleteArticle(ArticleEntity $article)
    {
        return $this->articleStorage->delete(['article_uuid' => $article->getArticle_uuid()]);
    }

}
