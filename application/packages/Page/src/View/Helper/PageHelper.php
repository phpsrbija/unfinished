<?php
declare(strict_types=1);
namespace Page\View\Helper;

use Page\Service\PageService;
use Zend\View\Helper\AbstractHelper;

class PageHelper extends AbstractHelper
{
    private $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function __invoke()
    {
        return $this;
    }

    /**
     * Fetch all pages for select box
     */
    public function forSelect()
    {
        return $this->pageService->getForSelect();
    }
}
