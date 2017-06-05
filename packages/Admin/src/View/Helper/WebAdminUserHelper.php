<?php

namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Core\Service\AdminUserService;

class WebAdminUserHelper extends AbstractHelper
{
    private $adminUserService;

    public function __construct(AdminUserService $adminUserService)
    {
        $this->adminUserService = $adminUserService;
    }

    public function __invoke()
    {
        return $this;
    }

    public function getRandom()
    {
        return $this->adminUserService->getForWeb(5);
    }

}