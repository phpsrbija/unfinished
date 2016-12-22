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
     * @param int $id
     *
     * @return array
     */
    public function fetchOne($id);

    /**
     * Creates a new entity.
     *
     * @param array $articleData
     *
     * @return bool
     */
    public function create($articleData);

    /**
     * Updates an entity.
     *
     * @param int $id
     * @param array $data
     *
     * @return mixed
     */
    public function updateArticle($id, $data);

    /**
     * Deletes an entity.
     *
     * @param array $where
     *
     * @return bool
     */
    public function delete($where);
}
