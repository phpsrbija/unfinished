<?php

declare(strict_types=1);

namespace Admin\View\Helper;

use Admin\Service\AdminUserService;
use Zend\View\Helper\AbstractHelper;

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
