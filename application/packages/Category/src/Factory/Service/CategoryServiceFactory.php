<?php

declare(strict_types=1);

namespace Category\Factory\Service;

use Category\Filter\CategoryFilter;
use Category\Mapper\CategoryMapper;
use Category\Service\CategoryService;
use Interop\Container\ContainerInterface;
use UploadHelper\Upload;

class CategoryServiceFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param ContainerInterface $container
     *
     * @return CategoryService
     */
    public function __invoke(ContainerInterface $container): CategoryService
    {
        $config = $container->get('config')['upload'];
        $upload = new Upload($config['public_path'], $config['non_public_path']);

        return new CategoryService(
            $container->get(CategoryMapper::class),
            $container->get(CategoryFilter::class),
            $upload
        );
    }
}
