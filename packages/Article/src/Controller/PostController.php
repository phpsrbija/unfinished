<?php

declare(strict_types = 1);

namespace Article\Controller;

use Core\Controller\AbstractController;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;
use Article\Service\PostService;
use Category\Service\CategoryService;
use Zend\Session\SessionManager;
use Zend\Expressive\Router\RouterInterface as Router;
use Core\Exception\FilterException;
use Zend\Http\PhpEnvironment\Request;

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
     * @var CategoryService
     */
    private $categoryService;

    /**
     * PostController constructor.
     *
     * @param Template        $template
     * @param Router          $router
     * @param PostService     $postService
     * @param SessionManager  $session
     * @param CategoryService $categoryService
     */
    public function __construct(
        Template $template,
        Router $router,
        PostService $postService,
        SessionManager $session,
        CategoryService $categoryService
    ) {
    
        $this->template        = $template;
        $this->postService     = $postService;
        $this->session         = $session;
        $this->router          = $router;
        $this->categoryService = $categoryService;
    }

    public function index() : HtmlResponse
    {
        $params = $this->request->getQueryParams();
        $page   = isset($params['page']) ? $params['page'] : 1;
        $limit  = isset($params['limit']) ? $params['limit'] : 15;
        $posts  = $this->postService->fetchAllArticles($page, $limit);

        return new HtmlResponse($this->template->render('article::post/index', ['list' => $posts, 'layout' => 'layout/admin']));
    }

    /**
     * Add/Edit show form
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function edit($errors = []) : \Psr\Http\Message\ResponseInterface
    {
        $id         = $this->request->getAttribute('id');
        $post       = $this->postService->fetchSingleArticle($id);
        $categories = $this->categoryService->getAll();

        if($this->request->getParsedBody()) {
            $post             = (object)($this->request->getParsedBody() + (array)$post);
            $post->article_id = $id;
        }

        return new HtmlResponse(
            $this->template->render(
                'article::post/edit', [
                'post'       => $post,
                'categories' => $categories,
                'errors'     => $errors,
                'layout'     => 'layout/admin'
                ]
            )
        );
    }

    /**
     * Add/Edit article action
     *
     * @throws FilterException if filter fails
     * @throws \Exception
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function save() : \Psr\Http\Message\ResponseInterface
    {
        try{
            $id   = $this->request->getAttribute('id');
            $user = $this->session->getStorage()->user;
            $data = $this->request->getParsedBody();
            $data += (new Request())->getFiles()->toArray();

            if($id) {
                $this->postService->updateArticle($data, $id);
            }
            else{
                $this->postService->createArticle($user, $data);
            }
        }
        catch(FilterException $fe){
            return $this->edit($fe->getArrayMessages());
        }
        catch(\Exception $e){
            throw $e;
        }

        return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.posts'));
    }

    /**
     * Delete post by id.
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
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
