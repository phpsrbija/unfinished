<?php

declare(strict_types=1);

namespace Menu\View\Helper;

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
