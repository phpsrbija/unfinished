<?php

namespace Admin\Model\Storage;

use Admin\Model\Entity\ArticleEntity;
use Zend\Db\ResultSet\ResultSetInterface;

interface ArticleStorageInterface
{
    /**
     * Fetches a list of entities from storage.
     *
     * @param $params
     *
     * @return ResultSetInterface
     */
    public function fetchAll($params);

    /**
     * Fetches a single entity from storage.
     *
     * @param $params
     *
     * @return ArticleEntity
     */
    public function fetchOne($params);

    /**
     * Creates a new entity.
     *
     * @param ArticleEntity $article
     *
     * @return bool
     */
    public function create(ArticleEntity $article);

    /**
     * Updates an entity.
     *
     * @param $article
     * @param null $where
     * @param array|null $joins
     *
     * @return mixed
     */
    public function update($article, $where = null, array $joins = null);

    /**
     * Deletes an entity.
     *
     * @param array $where
     *
     * @return bool
     */
    public function delete($where);
}