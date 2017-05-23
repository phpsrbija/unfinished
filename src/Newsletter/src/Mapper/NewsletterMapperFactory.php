<?php

declare(strict_types=1);

namespace Newsletter\Mapper;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;

class NewsletterMapperFactory
{
    public function __invoke(ContainerInterface $container): NewsletterMapper
    {
        return new NewsletterMapper(
            $container->get(Adapter::class)
        );
    }
}
