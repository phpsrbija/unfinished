<?php
declare(strict_types = 1);
namespace Category\View\Helper;

use Interop\Container\ContainerInterface;
use Category\Service\CategoryService;

/**
 * Class CategoryHelperFactory
 *
 * @package Category\View\Helper
 */
class CategoryHelperFactory
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null         $options
     * @return CategoryHelper
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CategoryHelper(
            $container->get(CategoryService::class)
        );
    }
}
