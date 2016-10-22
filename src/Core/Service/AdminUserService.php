<?php

namespace Core\Service;

use Core\Mapper\AdminUsersMapper;
use Zend\Crypt\Password\Bcrypt;

class AdminUserService
{
    private $adminUsersMapper;
    private $crypt;

    public function __construct(Bcrypt $crypt, AdminUsersMapper $adminUsersMapper)
    {
        $this->crypt            = $crypt;
        $this->adminUsersMapper = $adminUsersMapper;
    }

    public function loginUser($email, $password)
    {
        $user = $this->adminUsersMapper->getByEmail($email);

        if (!$user) {
            throw new \Exception('User does not exist.');
        }

        if (!$this->crypt->verify($password, $user->password)) {
            throw new \Exception('Password does not match.');
        }

        $this->adminUsersMapper->updateLogin($user->admin_user_uuid);

        return $user;
    }
}
