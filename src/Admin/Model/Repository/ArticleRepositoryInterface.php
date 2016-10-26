<?php

namespace Admin\Model\Repository;

use Admin\Model\Entity\ArticleEntity;
use Zend\Stdlib\ArrayObject;

/**
 * Interface ArticleRepositoryInterface.
 *
 * This interface defines crud operations for article repo.
 *
 * @package Admin\Model\Repository
 */
interface ArticleRepositoryInterface
{
    /**
     * Fetches a list of ArticleEntity models.
     *
     * @param array $params
     *
     * @return ArrayObject
     */
    public function fetchAllArticles($params = array());

    /**
     * Fetches a single ArticleEntity model.
     *
     * @param string $articleUuid
     *
     * @return ArticleEntity
     */
    public function fetchSingleArticle($articleUuid);

    /**
     * Saves article model taking care if it is an create or update operation.
     *
     * @param ArticleEntity $article
     *
     * @return bool
     */
    public function saveArticle(ArticleEntity $article);

    /**
     * Deletes a single article entity.
     *
     * @param ArticleEntity $article
     *
     * @return bool
     */
    public function deleteArticle(ArticleEntity $article);
}
