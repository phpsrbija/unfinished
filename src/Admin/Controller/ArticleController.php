<?php
declare(strict_types = 1);
namespace Admin\Controller;

use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;
use Core\Model\Repository\ArticleRepositoryInterface;
use Zend\Session\SessionManager;
use Zend\Expressive\Router\RouterInterface as Router;

class ArticleController extends AbstractController
{
    /**
     * @var Template
     */
    private $template;

    /**
     * @var \Core\Model\Repository\ArticleRepositoryInterface
     */
    private $articleRepo;

    /**
     * @var SessionManager
     */
    private $session;

    /**
     * @var Router
     */
    private $router;

    /**
     * ArticleController constructor.
     *
     * @param Template $template
     * @param ArticleRepositoryInterface $articleRepo
     * @param SessionManager $session
     * @param Router $router
     */
    public function __construct(Template $template, ArticleRepositoryInterface $articleRepo, SessionManager $session, Router $router)
    {
        $this->template    = $template;
        $this->articleRepo = $articleRepo;
        $this->session     = $session;
        $this->router      = $router;
    }

    public function index() : HtmlResponse
    {
        $params   = $this->request->getQueryParams();
        $page     = isset($params['page']) ? $params['page'] : 1;
        $limit    = isset($params['limit']) ? $params['limit'] : 15;
        $articles = $this->articleRepo->fetchAllArticles($page, $limit);

        return new HtmlResponse($this->template->render('admin::article/index', ['list' => $articles]));
    }

    /**
     * Add/Edit show form
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function edit() : \Psr\Http\Message\ResponseInterface
    {
        $id      = $this->request->getAttribute('id');
        $article = $this->articleRepo->fetchSingleArticle($id);

        return new HtmlResponse($this->template->render('admin::article/edit', ['article' => $article]));
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

            $this->articleRepo->saveArticle($user, $data, $id);
        }
        catch(\Exception $e){
            throw $e;
        }

        return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.articles'));
    }

    public function delete() : \Psr\Http\Message\ResponseInterface
    {
        try{
            $this->articleRepo->deleteArticle($this->request->getAttribute('id'));
        }
        catch(\Exception $e){
            throw $e;
        }

        return $this->response->withStatus(302)->withHeader(
            'Location', $this->router->generateUri('admin.articles', ['action' => 'index'])
        );
    }
}
