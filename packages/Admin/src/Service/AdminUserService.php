<?php

declare(strict_types=1);

namespace Admin\Service;

use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
use Admin\Mapper\AdminUsersMapper;
use Admin\Filter\AdminUserFilter;
use Core\Exception\FilterException;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Crypt\Password\Bcrypt;
use UploadHelper\Upload;

/**
 * Class AdminUserService.
 *
 * @package Core\Service
 */
class AdminUserService
{
    /** @var Bcrypt $crypt */
    private $crypt;

    /** @var AdminUsersMapper $adminUsersMapper */
    private $adminUsersMapper;

    /** @var AdminUserFilter $adminUserFilter */
    private $adminUserFilter;

    /** @var Upload $upload */
    private $upload;

    /**
     * AdminUserService constructor.
     *
     * @param Bcrypt           $crypt            bcrypt password encryption method
     * @param AdminUsersMapper $adminUsersMapper mapper for admin us
     * @param AdminUserFilter  $adminUserFilter
     * @param Upload           $upload
     */
    public function __construct(
        Bcrypt $crypt,
        AdminUsersMapper $adminUsersMapper,
        AdminUserFilter $adminUserFilter,
        Upload $upload
    )
    {
        $this->crypt            = $crypt;
        $this->adminUsersMapper = $adminUsersMapper;
        $this->adminUserFilter  = $adminUserFilter;
        $this->upload           = $upload;
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
        if(!$email || !$password) {
            throw new \Exception('Both email and password are required.', 400);
        }

        $user = $this->adminUsersMapper->getByEmail($email);

        if(!$user) {
            throw new \Exception('User does not exist.');
        }

        if(!$this->crypt->verify($password, $user->password)) {
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
        $select            = $this->adminUsersMapper->getPaginationSelect($userId);
        $paginationAdapter = new DbSelect($select, $this->adminUsersMapper->getAdapter());
        $pagination        = new Paginator($paginationAdapter);

        $pagination->setCurrentPageNumber($page);
        $pagination->setItemCountPerPage($limit);

        return $pagination;
    }

    /**
     * Return one user for given UUID
     *
     * @param  string $userId UUID from DB
     * @return array|\ArrayObject|null
     */
    public function getUser($userId)
    {
        return $this->adminUsersMapper->get($userId);
    }

    public function registerNewUser($data)
    {
        $filter = $this->adminUserFilter->getInputFilter()->setData($data);

        if(!$filter->isValid()) {
            throw new FilterException($filter->getMessages());
        }

        $data = $filter->getValues() + [
                'face_img'    => $this->upload->uploadImage($data, 'face_img'),
                'profile_img' => $this->upload->uploadImage($data, 'profile_img')
            ];

        unset($data['confirm_password']);
        $data['password']        = $this->crypt->create($data['password']);
        $data['admin_user_id']   = Uuid::uuid1()->toString();
        $data['admin_user_uuid'] = (new MysqlUuid($data['admin_user_id']))->toFormat(new Binary);

        return $this->adminUsersMapper->insert($data);
    }

    /**
     * Refactor it.
     */
    public function updateUser($data, $userId)
    {
        $user   = $this->getUser($userId);
        $filter = $this->adminUserFilter->getInputFilter()->setData($data);

        // we dont want to force user to enter the password again
        if($data['password'] == '') {
            $filter->remove('password');
            $filter->remove('confirm_password');
        }

        // if we want to keep same email
        if($user->email == $data['email']) {
            $filter->remove('email');
        }

        if(!$filter->isValid()) {
            throw new FilterException($filter->getMessages());
        }

        $data = $filter->getValues() + [
                'face_img'    => $this->upload->uploadImage($data, 'face_img'),
                'profile_img' => $this->upload->uploadImage($data, 'profile_img')
            ];

        // We don't want to force user to re-upload image on edit
        if(!$data['face_img']) {
            unset($data['face_img']);
        }
        else{
            $this->upload->deleteFile($user->face_img);
        }

        if(!$data['profile_img']) {
            unset($data['profile_img']);
        }
        else{
            $this->upload->deleteFile($user->profile_img);
        }

        if(isset($data['password'])) {
            unset($data['confirm_password']);
            $data['password'] = $this->crypt->create($data['password']);
        }

        return $this->adminUsersMapper->update($data, ['admin_user_id' => $userId]);
    }

    /**
     * Delete user by given UUID
     *
     * @param $userId
     * @return bool
     * @throws \Exception
     */
    public function delete($userId)
    {
        if(!($adminUser = $this->getUser($userId))){
            throw new \Exception('Admin user not found.');
        }

        $this->upload->deleteFile($adminUser->face_img);
        $this->upload->deleteFile($adminUser->profile_img);

        return (bool)$this->adminUsersMapper->delete(['admin_user_id' => $userId]);
    }

    /**
     * Fetch random X users to show on homepage
     *
     * @param int $limit
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getForWeb($limit = 10)
    {
        return $this->adminUsersMapper->getRandom($limit);
    }

    /**
     * Return all Admin User for select box
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getAll()
    {
        return $this->adminUsersMapper->select();
    }
}
