<?php

namespace Category\View\Helper;

use Interop\Container\ContainerInterface;
use Category\Service\CategoryService;

class CategoryHelperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CategoryHelper(
            $container->get(CategoryService::class)
        );
    }

}
