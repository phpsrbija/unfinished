<?php

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

    public function forMenu()
    {
        return $this->menuService->getNestedAll();
    }
}