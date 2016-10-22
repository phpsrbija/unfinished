<?php

namespace Core\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;

class AdminUsersMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    protected $table = 'admin_users';

    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getByEmail($email)
    {
        return $this->select(['email' => $email])->current();
    }

    public function updateLogin($id)
    {
        return $this->update(['last_login' => date('Y-m-d H:i:s')], ['admin_user_uuid' => $id]);
    }
}
