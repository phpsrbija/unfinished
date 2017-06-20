<?php

namespace Admin\Factory\View\Helper;

use Admin\View\Helper\WebAdminUserHelper;
use Core\Service\AdminUserService;
use Interop\Container\ContainerInterface;

class WebAdminUserHelperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new WebAdminUserHelper(
            $container->get(AdminUserService::class)
        );
    }

}
