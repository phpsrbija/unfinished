<?php

declare(strict_types=1);

namespace Menu\Factory\Service;

use Category\Service\CategoryService;
use Interop\Container\ContainerInterface;
use Menu\Filter\MenuFilter;
use Menu\Mapper\MenuMapper;
use Menu\Service\MenuService;
use Page\Service\PageService;

class MenuServiceFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MenuService(
            $container->get(MenuMapper::class),
            $container->get(MenuFilter::class),
            $container->get(CategoryService::class),
            $container->get(PageService::class)
        );
    }
}
