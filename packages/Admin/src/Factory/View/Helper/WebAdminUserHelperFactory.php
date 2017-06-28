<?php
declare(strict_types = 1);
namespace Admin\Factory\View\Helper;

use Admin\View\Helper\WebAdminUserHelper;
use Admin\Service\AdminUserService;
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
