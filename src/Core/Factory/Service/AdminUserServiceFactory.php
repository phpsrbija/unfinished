<?php

namespace Core\Factory\Service;

use Core\Mapper\AdminUsersMapper;
use Core\Service\AdminUserService;
use Interop\Container\ContainerInterface;
use Zend\Crypt\Password\Bcrypt;

class AdminUserServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AdminUserService(
            new Bcrypt(),
            $container->get(AdminUsersMapper::class)
        );
    }
}