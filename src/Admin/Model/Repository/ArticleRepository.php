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

    public function __construct(ArticleStorageInterface $articleStorage)
    {
        $this->articleStorage = $articleStorage;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function fetchAllArticles($params = array())
    {
        return $this->articleStorage->fetchAll($params);
    }

    /**
     * @param string $articleUuid
     * @return ArticleEntity
     */
    public function fetchSingleArticle($articleUuid)
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
    public function saveArticle(ArticleEntity $article)
    {
        if (!$article->getArticle_uuid()) {
            return $this->articleStorage->create($article);
        } else {
            return $this->articleStorage->update($article);
        }
    }

    public function deleteArticle(ArticleEntity $article)
    {
        return $this->articleStorage->delete(['article_uuid' => $article->getArticle_uuid()]);
    }

}