<?php
declare(strict_types=1);

namespace Core\Factory\Service;

use Core\Mapper\AdminUsersMapper;
use Core\Service\AdminUserService;
use Core\Filter\AdminUserFilter;
use Interop\Container\ContainerInterface;
use Zend\Crypt\Password\Bcrypt;
use UploadHelper\Upload;

class AdminUserServiceFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param  ContainerInterface $container container
     * @return AdminUserService
     */
    public function __invoke(ContainerInterface $container): AdminUserService
    {
        $config = $container->get('config')['upload'];
        $upload = new Upload($config['public_path'], $config['non_public_path']);

        return new AdminUserService(
            new Bcrypt(),
            $container->get(AdminUsersMapper::class),
            $container->get(AdminUserFilter::class),
            $upload
        );
    }
}
