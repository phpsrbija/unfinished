<?php

declare(strict_types=1);

namespace Page\Service;

use Interop\Container\ContainerInterface;
use Page\Filter\PageFilter;
use Page\Mapper\PageMapper;
use UploadHelper\Upload;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class PageServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')['upload'];
        $upload = new Upload($config['public_path'], $config['non_public_path']);

        // Create pagination object
        $pageMapper = $container->get(PageMapper::class);
        $select = $pageMapper->getPaginationSelect();
        $paginationAdapter = new DbSelect($select, $pageMapper->getAdapter(), $pageMapper->getResultSetPrototype());
        $pagination = new Paginator($paginationAdapter);

        return new PageService(
            $container->get(PageFilter::class),
            $pageMapper,
            $pagination,
            $upload
        );
    }
}
