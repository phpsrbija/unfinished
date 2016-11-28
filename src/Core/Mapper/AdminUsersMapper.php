<?php
declare(strict_types = 1);
namespace Core\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;

/**
 * Class AdminUsersMapper.
 *
 * @package Core\Mapper
 */
class AdminUsersMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    /**
     * @var string
     */
    protected $table = 'admin_users';

    /**
     * Db adapter setter method,
     *
     * @param Adapter $adapter db adapter
     * @return void
     */
    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get admin user by email.
     *
     * @param string $email email
     * @return array|\ArrayObject|null
     */
    public function getByEmail(string $email)
    {
        return $this->select(['email' => $email])->current();
    }

    /**
     * Updates login data.
     *
     * @param string $uuid admin user uuid
     * @return int number of affected rows
     */
    public function updateLogin(string $uuid) : int
    {
        return $this->update(['last_login' => date('Y-m-d H:i:s')], ['admin_user_uuid' => $uuid]);
    }

    public function getPaginationSelect($userId)
    {
        $select = $this->getSql()->select()->order(['created_at' => 'desc']);

        $select->where->notEqualTo('admin_user_uuid', $userId);

        return $select;
    }
}
