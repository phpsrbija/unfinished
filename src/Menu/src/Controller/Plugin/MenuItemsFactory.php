<?php

namespace Menu\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Menu\Service\MenuService;

class MenuItemsFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MenuItems(
            $container->get(MenuService::class)
        );
    }

}