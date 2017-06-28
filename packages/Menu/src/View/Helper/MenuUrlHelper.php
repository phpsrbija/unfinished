<?php
declare(strict_types=1);
namespace Menu\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Expressive\Helper\UrlHelper;
use Article\Service\PostService;

class MenuUrlHelper extends AbstractHelper
{
    /**
     * @var UrlHelper
     */
    private $url;

    /**
     * MenuUrlHelper constructor.
     *
     * @param UrlHelper $url
     */
    public function __construct(UrlHelper $url)
    {
        $this->url = $url;
    }

    /**
     * Depend on given MenuItem create URL
     *
     * @param  $menuItem
     * @return String
     */
    public function __invoke($menuItem)
    {
        if ($menuItem['href']) {
            return strpos($menuItem['href'], 'http') === 0 ? $menuItem['href'] : '/' . $menuItem['href'];
        } elseif ($menuItem['page_slug']) {
            return $this->url->__invoke('page', ['url_slug' => $menuItem['page_slug']]);
        } elseif ($menuItem['category_slug']) {
            return $this->url->__invoke('category', ['category' => $menuItem['category_slug']]);
        } else {
            return '#';
        }
    }
}
