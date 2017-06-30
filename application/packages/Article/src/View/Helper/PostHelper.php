<?php
declare(strict_types = 1);
namespace Article\View\Helper;

use Article\Service\PostService;
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
     * Fetch all posts for select box
     */
    public function forSelect()
    {
        return $this->postService->getForSelect();
    }

    public function forWeb()
    {
        $limit = 7;

        return $this->postService->getLatestWeb($limit);
    }
}
