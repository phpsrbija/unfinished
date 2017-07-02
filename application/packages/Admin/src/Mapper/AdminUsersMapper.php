<?php

declare(strict_types=1);

namespace Admin\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Sql\Expression;
use Zend\Db\TableGateway\AbstractTableGateway;

/**
 * Class AdminUsersMapper.
 */
class AdminUsersMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    /**
     * @var string
     */
    protected $table = 'admin_users';

    /**
     * Db adapter setter method,.
     *
     * @param Adapter $adapter db adapter
     *
     * @return void
     */
    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function get($id)
    {
        return $this->select(['admin_user_id' => $id])->current();
    }

    /**
     * Get admin user by email.
     *
     * @param string $email email
     *
     * @return array|\ArrayObject|null
     */
    public function getByEmail(string $email)
    {
        return $this->select(['email' => $email])->current();
    }

    /**
     * Updates login data.
     *
     * @param string $uuid admin user id
     *
     * @return int number of affected rows
     */
    public function updateLogin(string $userId): int
    {
        return $this->update(['last_login' => date('Y-m-d H:i:s')], ['admin_user_id' => $userId]);
    }

    public function getPaginationSelect($userId)
    {
        $select = $this->getSql()->select()->order(['created_at' => 'desc']);

        $select->where->notEqualTo('admin_user_id', $userId);

        return $select;
    }

    public function getRandom($limit)
    {
        $select = $this->getSql()->select()
            ->where(['status' => 1])
            ->order(new Expression('rand()'))
            ->limit($limit);

        return $this->selectWith($select);
    }

    public function getUuid($adminUserId)
    {
        $user = $this->select(['admin_user_id' => $adminUserId])->current();

        if (!$user) {
            throw new \Exception('Admin user does not exist!', 400);
        }

        return $user->admin_user_uuid;
    }
}
