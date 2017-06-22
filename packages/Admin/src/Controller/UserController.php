<?php

declare(strict_types=1);

namespace Admin\Controller;

use Core\Controller\AbstractController;
use Admin\Service\AdminUserService;
use Core\Exception\FilterException;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Session\SessionManager;
use Zend\Http\PhpEnvironment\Request;

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

    /**
     * @var Router
     */
    private $router;

    /**
     * @var AdminUserService
     */
    private $adminUserService;

    /**
     * @var SessionManager
     */
    private $session;

    /**
     * UserController constructor.
     *
     * @param Template         $template
     * @param Router           $router
     * @param AdminUserService $adminUserService
     * @param SessionManager   $session
     */
    public function __construct(Template $template, Router $router, AdminUserService $adminUserService, SessionManager $session)
    {
        $this->template         = $template;
        $this->router           = $router;
        $this->adminUserService = $adminUserService;
        $this->session          = $session;
    }

    /**
     * Users list, exclude current logged in user from the list.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(): \Psr\Http\Message\ResponseInterface
    {
        $user   = $this->session->getStorage()->user;
        $params = $this->request->getQueryParams();
        $page   = isset($params['page']) ? $params['page'] : 1;
        $limit  = isset($params['limit']) ? $params['limit'] : 15;

        $adminUsers = $this->adminUserService->getPagination($page, $limit, $user->admin_user_id);

        return new HtmlResponse($this->template->render('admin::user/index', ['list' => $adminUsers, 'layout' => 'layout/admin']));
    }

    /**
     * Edit one user by givven UUID from route.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function edit($errors = []): \Psr\Http\Message\ResponseInterface
    {
        $id   = $this->request->getAttribute('id');
        $user = $this->adminUserService->getUser($id);

        if($this->request->getParsedBody()) {
            $user                = (object)($this->request->getParsedBody() + (array)$user);
            $user->admin_user_id = $id;
        }

        return new HtmlResponse(
            $this->template->render(
                'admin::user/edit', [
                'user'   => $user,
                'errors' => $errors,
                'layout' => 'layout/admin'
                ]
            )
        );
    }

    public function save()
    {
        try {
            $userId = $this->request->getAttribute('id');
            $data   = $this->request->getParsedBody();
            $data   += (new Request())->getFiles()->toArray();

            if($userId) {
                $this->adminUserService->updateUser($data, $userId);
            }
            else {
                $this->adminUserService->registerNewUser($data);
            }

            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.users'));
        }
        catch(FilterException $fe) {
            return $this->edit($fe->getArrayMessages());
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    public function delete()
    {
        try {
            $userId = $this->request->getAttribute('id');
            $this->adminUserService->delete($userId);

            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.users'));
        }
        catch(\Exception $e) {
            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.users'));
        }
    }
}
