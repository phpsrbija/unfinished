<?php

namespace Core\Service;

/**
 * Interface ArticleServiceInterface.
 *
 * @package Admin\Service
 */
interface ArticleServiceInterface
{
    /**
     * Fetches a list of ArticleEntity models.
     *
     * @param array $params
     * @return ArrayObject
     */
    public function fetchAllArticles($page, $limit);

    /**
     * Fetches a single ArticleEntity model.
     *
     * @param string $articleId
     * @return ArticleEntity
     */
    public function fetchSingleArticle($articleId);

    /**
     * Updates article model.
     *
     * @return bool
     */
    public function saveArticle($user, $data, $id = null);

    /**
     * Deletes a single article entity.
     *
     * @param string $id
     * @return bool
     */
    public function deleteArticle($id);
}
