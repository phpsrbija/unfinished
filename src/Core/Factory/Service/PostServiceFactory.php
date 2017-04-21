<?php
declare(strict_types = 1);
namespace Core\Factory\Service;

use Core\Mapper\ArticleMapper;
use Core\Mapper\ArticleTagsMapper;
use Core\Mapper\ArticlePostsMapper;
use Core\Mapper\TagsMapper;
use Core\Service\Article\PostService;
use Core\Filter\ArticleFilter;
use Core\Filter\PostFilter;
use Interop\Container\ContainerInterface;
use UploadHelper\Upload;

class PostServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return PostService
     */
    public function __invoke(ContainerInterface $container) : PostService
    {
        $config = $container->get('config')['upload'];
        $upload = new Upload($config['public_path'], $config['non_public_path']);

        return new PostService(
            $container->get(ArticleMapper::class),
            $container->get(ArticlePostsMapper::class),
            $container->get(ArticleFilter::class),
            $container->get(PostFilter::class),
            $container->get(ArticleTagsMapper::class),
            $container->get(TagsMapper::class),
            $upload
        );
    }
}
