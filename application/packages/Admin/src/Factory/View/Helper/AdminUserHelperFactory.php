<?php

declare(strict_types=1);

namespace Admin\Factory\View\Helper;

use Admin\Service\AdminUserService;
use Admin\View\Helper\AdminUserHelper;
use Interop\Container\ContainerInterface;

class AdminUserHelperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AdminUserHelper(
            $container->get('session'),
            $container->get(AdminUserService::class)
        );
    }
}
