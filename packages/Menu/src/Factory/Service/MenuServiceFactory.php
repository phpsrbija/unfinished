<?php

namespace Menu\Factory\Service;

use Interop\Container\ContainerInterface;
use Menu\Service\MenuService;
use Menu\Mapper\MenuMapper;
use Menu\Filter\MenuFilter;
use Category\Service\CategoryService;
use Article\Service\PostService;

class MenuServiceFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MenuService(
            $container->get(MenuMapper::class),
            $container->get(MenuFilter::class),
            $container->get(CategoryService::class),
            $container->get(PostService::class)
        );
    }

}