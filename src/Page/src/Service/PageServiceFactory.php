<?php

namespace Page\Service;

use Interop\Container\ContainerInterface;
use Page\Mapper\PageMapper;
use Page\Filter\PageFilter;
use UploadHelper\Upload;

class PageServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')['upload'];
        $upload = new Upload($config['public_path'], $config['non_public_path']);

        return new PageService(
            $container->get(PageMapper::class),
            $container->get(PageFilter::class),
            $upload
        );
    }
}
