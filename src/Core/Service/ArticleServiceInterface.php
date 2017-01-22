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
     * When you want to add new article.
     *
     * @param $user User array from the session. We will use user_id to know who create the article.
     * @param $data
     * @return mixed
     */
    public function createArticle($user, $data);

    /**
     * Update one article.
     *
     * @param $data
     * @param $id
     * @return mixed
     */
    public function updateArticle($data, $id);

    /**
     * Deletes a single article entity.
     *
     * @param string $id
     * @return bool
     */
    public function deleteArticle($id);
}
