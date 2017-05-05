<?php

namespace Core\View\Helper;

use Core\Service\Article\PostService;
use Zend\View\Helper\AbstractHelper;

class PostHelper extends AbstractHelper
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

    /**
     * Fetch all posts for select box in Admin
     */
    public function forSelect()
    {
        return $this->postService->getForSelect();
    }
}