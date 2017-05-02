<?php

namespace Menu\Controller\Plugin;

use Menu\Service\MenuService;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class MenuItems extends AbstractPlugin
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