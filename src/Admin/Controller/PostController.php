<?php
declare(strict_types = 1);
namespace Admin\Controller;

use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;
use Core\Service\PostService;
use Zend\Session\SessionManager;
use Zend\Expressive\Router\RouterInterface as Router;

class PostController extends AbstractController
{
    /**
     * @var Template
     */
    private $template;

    /**
     * @var \Core\Service\PostService
     */
    private $postService;

    /**
     * @var SessionManager
     */
    private $session;

    /**
     * @var Router
     */
    private $router;

    /**
     * PostController constructor.
     *
     * @param Template $template
     * @param PostService $postService
     * @param SessionManager $session
     * @param Router $router
     */
    public function __construct(Template $template, PostService $postService, SessionManager $session, Router $router)
    {
        $this->template    = $template;
        $this->postService = $postService;
        $this->session     = $session;
        $this->router      = $router;
    }

    public function index() : HtmlResponse
    {
        $params = $this->request->getQueryParams();
        $page   = isset($params['page']) ? $params['page'] : 1;
        $limit  = isset($params['limit']) ? $params['limit'] : 15;
        $posts  = $this->postService->fetchAllArticles($page, $limit);

        return new HtmlResponse($this->template->render('admin::post/index', ['list' => $posts]));
    }

    /**
     * Add/Edit show form
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function edit() : \Psr\Http\Message\ResponseInterface
    {
        $id   = $this->request->getAttribute('id');
        $post = $this->postService->fetchSingleArticle($id);

        return new HtmlResponse($this->template->render('admin::post/edit', ['post' => $post]));
    }

    /**
     * Add/Edit  article action
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function doedit() : \Psr\Http\Message\ResponseInterface
    {
        try{
            $id   = $this->request->getAttribute('id');
            $data = $this->request->getParsedBody();
            $user = $this->session->getStorage()->user;

            $this->postService->saveArticle($user, $data, $id);
        }
        catch(\Exception $e){
            throw $e;
        }

        return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.posts'));
    }

    public function delete() : \Psr\Http\Message\ResponseInterface
    {
        try{
            $this->postService->deleteArticle($this->request->getAttribute('id'));
        }
        catch(\Exception $e){
            throw $e;
        }

        return $this->response->withStatus(302)->withHeader(
            'Location', $this->router->generateUri('admin.posts', ['action' => 'index'])
        );
    }
}
