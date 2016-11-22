<?php
declare(strict_types = 1);
namespace Admin\Controller;

use Core\Service\AdminUserService;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Session\SessionManager;

/**
 * Class AuthController.
 * Deals with handlers which work with admin user authentication.
 *
 * @package Admin\Controller
 */
final class AuthController extends AbstractController
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var Template
     */
    private $template;

    /**
     * @var SessionManager
     */
    private $session;

    /**
     * @var AdminUserService
     */
    private $adminUserService;

    /**
     * AuthController constructor.
     *
     * @param Router           $router           router
     * @param Template         $template         template engine
     * @param SessionManager   $session          session manager
     * @param AdminUserService $adminUserService admin user service
     */
    public function __construct(
        Router $router,
        Template $template,
        SessionManager $session,
        AdminUserService $adminUserService
    ) {
        $this->router           = $router;
        $this->template         = $template;
        $this->session          = $session;
        $this->adminUserService = $adminUserService;
    }

    /**
     * Performs session check and redirects user to appropriate page or displays login page.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login() : \Psr\Http\Message\ResponseInterface
    {
        if ($this->session->getStorage()->user) {
            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
        }

        return new HtmlResponse($this->template->render('admin::login'));
    }

    /**
     * Performs user credentials check and registers admin session if valid.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function loginHandle() : \Psr\Http\Message\ResponseInterface
    {
        if ($this->session->getStorage()->user) {
            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
        }

        $data     = $this->request->getParsedBody();
        $email    = isset($data['email']) ? $data['email'] : null;
        $password = isset($data['password']) ? $data['password'] : null;

        try {
            $this->session->getStorage()->user = $this->adminUserService->loginUser($email, $password);

            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
        } catch (\Exception $e) {
            //@todo set $e->getMessage() to flash messanger and print messages in next page
            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
        }
    }

    /**
     * Clears user session.
     *
     * @return static
     */
    public function logout() : \Psr\Http\Message\ResponseInterface
    {
        $this->session->getStorage()->clear('user');

        return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
    }
}
