<?php

namespace Page\View\Helper;

use Page\Service\PageService;
use Interop\Container\ContainerInterface;

class PageHelperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PageHelper(
            $container->get(PageService::class)
        );
    }

}
