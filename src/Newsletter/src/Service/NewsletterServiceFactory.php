<?php

declare(strict_types=1);

namespace Newsletter\Service;

use Interop\Container\ContainerInterface;
use Newsletter\Mapper\NewsletterMapper;

class NewsletterServiceFactory
{
    public function __invoke(ContainerInterface $container): NewsletterService
    {
        return new NewsletterService(
            $container->get(NewsletterMapper::class)
        );
    }
}
