<?php

namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Session\SessionManager;

class AdminUserHelper extends AbstractHelper
{
    private $session;

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    public function __invoke()
    {
        return $this->session->getStorage()->user;
    }

}