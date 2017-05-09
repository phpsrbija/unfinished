<?php

namespace Menu\View\Helper;

use Menu\Service\MenuService;
use Interop\Container\ContainerInterface;

class MenuItemsFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MenuItems(
            $container->get(MenuService::class)
        );
    }

}