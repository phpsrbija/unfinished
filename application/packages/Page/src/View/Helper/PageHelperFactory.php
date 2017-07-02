<?php

declare(strict_types=1);

namespace Page\View\Helper;

use Interop\Container\ContainerInterface;
use Page\Service\PageService;

class PageHelperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PageHelper(
            $container->get(PageService::class)
        );
    }
}
