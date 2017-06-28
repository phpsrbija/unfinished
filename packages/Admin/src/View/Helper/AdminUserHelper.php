<?php
declare(strict_types = 1);
namespace Admin\View\Helper;

use Admin\Service\AdminUserService;
use Zend\View\Helper\AbstractHelper;
use Zend\Session\SessionManager;

class AdminUserHelper extends AbstractHelper
{
    private $session;
    private $adminUserService;

    public function __construct(SessionManager $session, AdminUserService $adminUserService)
    {
        $this->session = $session;
        $this->adminUserService = $adminUserService;
    }

    public function __invoke()
    {
        return $this;
    }

    public function current()
    {
        return $this->session->getStorage()->user;
    }

    public function all()
    {
        return $this->adminUserService->getAll();
    }
}
