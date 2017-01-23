<?php

namespace Core\Service\Article;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

abstract class ArticleService implements ArticleServiceInterface
{
    private $articleMapper;
    private $articleFilter;

    protected function __construct($articleMapper, $articleFilter)
    {
        $this->articleMapper = $articleMapper;
        $this->articleFilter = $articleFilter;
    }

    public function getPagination($select, $page, $limit)
    {
        $paginatorAdapter = new DbSelect($select, $this->articleMapper->getAdapter());
        $paginator        = new Paginator($paginatorAdapter);

        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($limit);

        return $paginator;
    }

    public function getTagIds($articleId)
    {
        $tags = [];
        foreach($this->articleMapper->getTages($articleId) as $tag){
            $tags[] = $tag->tag_id;
        }

        return $tags;
    }

    public function delete($articleId)
    {
        $this->articleMapper->deleteTags($articleId);
        $this->articleMapper->delete(['article_uuid' => $articleId]);
    }
}