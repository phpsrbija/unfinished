<?php

declare(strict_types=1);

namespace Menu\View\Helper;

use Menu\Service\MenuService;
use Zend\View\Helper\AbstractHelper;

class MenuItems extends AbstractHelper
{
    private $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function __invoke()
    {
        return $this;
    }

    /**
     * Get all menu items.
     */
    public function forMenu()
    {
        return $this->menuService->getNestedAll();
    }

    public function getHeaderMenu()
    {
        return $this->menuService->getNestedAll(true, ['is_in_header' => true]);
    }

    public function getFooterMenu()
    {
        return $this->menuService->getNestedAll(true, ['is_in_footer' => true]);
    }

    public function getSideMenu()
    {
        return $this->menuService->getNestedAll(true, ['is_in_side' => true]);
    }
}
