<?php
declare(strict_types=1);

namespace Article\Factory\Service;

use Article\Mapper\ArticleMapper;
use Article\Mapper\ArticlePostsMapper;
use Article\Service\PostService;
use Article\Filter\ArticleFilter;
use Article\Filter\PostFilter;
use Category\Mapper\CategoryMapper;
use Admin\Mapper\AdminUsersMapper;
use Interop\Container\ContainerInterface;
use UploadHelper\Upload;

class PostServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return PostService
     */
    public function __invoke(ContainerInterface $container): PostService
    {
        $config = $container->get('config')['upload'];
        $upload = new Upload($config['public_path'], $config['non_public_path']);

        return new PostService(
            $container->get(ArticleMapper::class),
            $container->get(ArticlePostsMapper::class),
            $container->get(ArticleFilter::class),
            $container->get(PostFilter::class),
            $container->get(CategoryMapper::class),
            $upload,
            $container->get(AdminUsersMapper::class)
        );
    }
}
