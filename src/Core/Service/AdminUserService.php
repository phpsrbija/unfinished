<?php
declare(strict_types = 1);

namespace Core\Service;

use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
use Core\Mapper\AdminUsersMapper;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Crypt\Password\Bcrypt;

/**
 * Class AdminUserService.
 *
 * @package Core\Service
 */
class AdminUserService
{
    /**
     * @var AdminUsersMapper
     */
    private $adminUsersMapper;

    /**
     * @var Bcrypt
     */
    private $crypt;

    /**
     * AdminUserService constructor.
     *
     * @param Bcrypt $crypt                      bcrypt password encryption method
     * @param AdminUsersMapper $adminUsersMapper mapper for admin us
     */
    public function __construct(Bcrypt $crypt, AdminUsersMapper $adminUsersMapper)
    {
        $this->crypt            = $crypt;
        $this->adminUsersMapper = $adminUsersMapper;
    }

    /**
     * Performs user login or throws exception if credentials are not valid.
     *
     * @param  string $email    user email
     * @param  string $password user password
     * @return array|\ArrayObject|null
     * @throws \Exception if user does not exist or password is not valid
     */
    public function loginUser($email, $password)
    {
        $user = $this->adminUsersMapper->getByEmail($email);

        if(!$user){
            throw new \Exception('User does not exist.');
        }

        if(!$this->crypt->verify($password, $user->password)){
            throw new \Exception('Password does not match.');
        }

        $this->adminUsersMapper->updateLogin($user->admin_user_id);

        return $user;
    }

    /**
     * Return pagination object to paginate results on view
     *
     * @param  int $page      Current page set to pagination to display
     * @param  int $limit     Limit set to pagination
     * @param  string $userId UUID from DB
     * @return Paginator
     */
    public function getPagination($page, $limit, $userId)
    {
        $select           = $this->adminUsersMapper->getPaginationSelect($userId);
        $paginatorAdapter = new DbSelect($select, $this->adminUsersMapper->getAdapter());
        $paginator        = new Paginator($paginatorAdapter);

        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($limit);

        return $paginator;
    }

    /**
     * Return one user for given UUID
     *
     * @param  string $userId UUID from DB
     * @return array|\ArrayObject|null
     */
    public function getUser($userId)
    {
        if(!$userId){
            return;
        }

        $user = $this->adminUsersMapper->get($userId);

        return $user;
    }

    /**
     * Update or Insert user.
     *
     * @todo Validate/filter data
     * @param  Array $data  Data from POST
     * @param  null $userId UUID of user if we want to edit or 0 to add new user
     * @throws \Exception
     */
    public function save($data, $userId = 0)
    {
        if($data['password'] == ''){
            unset($data['password']);
        }
        else{
            $data['password'] = $this->crypt->create($data['password']);
        }

        if($userId){
            $this->adminUsersMapper->update($data, ['admin_user_id' => $userId]);
        }
        else{
            $data['admin_user_id']   = Uuid::uuid1()->toString();
            $data['admin_user_uuid'] = (new MysqlUuid($data['admin_user_id']))->toFormat(new Binary);
            $this->adminUsersMapper->insert($data);
        }
    }

    /**
     * Delete user by given UUID
     *
     * @param  string $userId UUID from DB
     * @return bool
     */
    public function delete($userId)
    {
        return (bool)$this->adminUsersMapper->delete(['admin_user_id' => $userId]);
    }
}
