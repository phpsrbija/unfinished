<?php

declare(strict_types=1);

namespace Category\View\Helper;

use Category\Service\CategoryService;
use Interop\Container\ContainerInterface;

/**
 * Class CategoryHelperFactory.
 */
class CategoryHelperFactory
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     *
     * @return CategoryHelper
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CategoryHelper(
            $container->get(CategoryService::class)
        );
    }
}
