<?php

namespace Admin\Factory\View\Helper;

use Admin\View\Helper\AdminUserHelper;
use Core\Service\AdminUserService;
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
