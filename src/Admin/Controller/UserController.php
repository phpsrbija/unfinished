<?php

declare(strict_types = 1);

namespace Admin\Controller;

use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;
use Core\Service\AdminUserService;

/**
 * Class UserController.
 *
 * @package Admin\Controller
 */
class UserController extends AbstractController
{
    /**
     * @var Template
     */
    private $template;
    private $adminUserService;

    CONST DEFAUTL_LIMIT = 15;
    CONST DEFAUTL_PAGE  = 1;

    /**
     * UserController constructor.
     *
     * @param Template $template template engine
     */
    public function __construct(Template $template, AdminUserService $adminUserService)
    {
        $this->template         = $template;
        $this->adminUserService = $adminUserService;
    }

    /**
     * Users list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index() : \Psr\Http\Message\ResponseInterface
    {
        $params = $this->request->getQueryParams();
        $page   = isset($params['page']) ? $params['page'] : self::DEFAUTL_PAGE;
        $limit  = isset($params['limit']) ? $params['limit'] : self::DEFAUTL_LIMIT;

        //$filter = [
        //    'country'    => isset($params['country']) ? $params['country'] : '',
        //    'tournament' => isset($params['tournament']) ? $params['tournament'] : 0,
        //    'sport'      => isset($params['sport']) ? $params['sport'] : 0
        //];

        $adminUsers = $this->adminUserService->getPagination($page, $limit);

        return new HtmlResponse($this->template->render('admin::user/index', ['list' => $adminUsers]));
    }
}
