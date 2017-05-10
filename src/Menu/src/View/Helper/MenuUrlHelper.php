<?php

namespace Menu\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Expressive\Helper\UrlHelper;
use Article\Service\PostService;

class MenuUrlHelper extends AbstractHelper
{
    /** @var UrlHelper */
    private $url;

    /** @var PostService */
    private $postService;

    /**
     * MenuUrlHelper constructor.
     *
     * @param UrlHelper $url
     */
    public function __construct(UrlHelper $url, PostService $postService)
    {
        $this->url         = $url;
        $this->postService = $postService;
    }

    /**
     * Depend on given MenuItem create URL
     *
     * @param $menuItem
     * @return String
     */
    public function __invoke($menuItem)
    {
        if($menuItem['href']) {
            return strpos($menuItem['href'], 'http') === 0 ? $menuItem['href'] : '/' . $menuItem['href'];
        }
        elseif($menuItem['article_slug']) {
            // @todo refactor - break categories into single category per article...
            $category = $this->postService->getCategories($menuItem['article_id'])->current();

            if($category){
                $params = ['segment_1' => $category->slug, 'segment_2' => $menuItem['article_slug']];
            }
            else{
                $params = ['segment_1' => $menuItem['article_slug']];
            }

            return $this->url->__invoke('post', $params);
        }
        elseif($menuItem['category_slug']) {
            return $this->url->__invoke('category', ['category' => $menuItem['category_slug']]);
        }
        else {
            return '#';
        }
    }
}