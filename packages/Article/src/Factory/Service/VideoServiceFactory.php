<?php
declare(strict_types=1);

namespace Article\Factory\Service;

use Article\Mapper\ArticleMapper;
use Article\Mapper\ArticleVideosMapper;
use Article\Service\VideoService;
use Article\Filter\ArticleFilter;
use Article\Filter\VideoFilter;
use Category\Mapper\CategoryMapper;
use Admin\Mapper\AdminUsersMapper;
use Interop\Container\ContainerInterface;
use UploadHelper\Upload;

class VideoServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return VideoService
     */
    public function __invoke(ContainerInterface $container): VideoService
    {
        $config = $container->get('config')['upload'];
        $upload = new Upload($config['public_path'], $config['non_public_path']);

        return new VideoService(
            $container->get(ArticleMapper::class),
            $container->get(ArticleVideosMapper::class),
            $container->get(ArticleFilter::class),
            $container->get(VideoFilter::class),
            $container->get(CategoryMapper::class),
            $upload,
            $container->get(AdminUsersMapper::class)
        );
    }
}
