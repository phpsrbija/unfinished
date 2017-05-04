<?php

namespace Core\View\Helper;

use Core\Service\Article\PostService;
use Zend\View\Helper\AbstractHelper;

class ArticleHelper extends AbstractHelper
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function __invoke()
    {
        return $this;
    }

    public function forSelect()
    {
        return $this->postService->fetchAllArticles(1, 1000);
    }
}