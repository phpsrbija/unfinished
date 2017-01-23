<?php
declare(strict_types = 1);
namespace Core\Factory\Service;

use Core\Mapper\ArticleMapper;
use Core\Mapper\ArticleTagsMapper;
use Core\Mapper\ArticleVideosMapper;
use Core\Mapper\TagsMapper;
use Core\Service\Article\VideoService;
use Core\Filter\ArticleFilter;
use Core\Filter\VideoFilter;
use Interop\Container\ContainerInterface;
use UploadHelper\Upload;

class VideoServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return VideoService
     */
    public function __invoke(ContainerInterface $container) : VideoService
    {
        $config = $container->get('config')->upload;
        $upload = new Upload($config['public_path'], $config['non_public_path']);

        return new VideoService(
            $container->get(ArticleMapper::class),
            $container->get(ArticleVideosMapper::class),
            $container->get(ArticleFilter::class),
            $container->get(VideoFilter::class),
            $container->get(ArticleTagsMapper::class),
            $container->get(TagsMapper::class),
            $upload
        );
    }
}
