<?php

namespace Admin\Model\Repository;

use Admin\Model\Entity\ArticleEntity;
use Zend\Stdlib\ArrayObject;
use Psr\Http\Message\ServerRequestInterface as Request;

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
     * Creates article model.
     *
     * @param Request $request
     * @param string  $adminUserUuid
     *
     * @return bool
     */
    public function createArticle(Request $request, $adminUserUuid);

    /**
     * Updates article model.
     *
     * @param Request $request
     * @param string  $adminUserUuid
     *
     * @return bool
     */
    public function updateArticle(Request $request, $adminUserUuid);

    /**
     * Deletes a single article entity.
     *
     * @param string $id
     *
     * @return bool
     */
    public function deleteArticle($id);
}
