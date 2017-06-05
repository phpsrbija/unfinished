<?php
declare(strict_types = 1);
namespace Category\Factory\Service;

use Category\Mapper\CategoryMapper;
use Category\Service\CategoryService;
use Interop\Container\ContainerInterface;
use Category\Filter\CategoryFilter;

class CategoryServiceFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param ContainerInterface $container container
     * @return AdminUserService
     */
    public function __invoke(ContainerInterface $container) : CategoryService
    {
        return new CategoryService(
            $container->get(CategoryMapper::class),
            $container->get(CategoryFilter::class)
        );
    }
}
