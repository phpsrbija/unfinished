<?php

declare(strict_types = 1);

namespace Admin\Controller;

use Core\Service\DiscussionService;
use Core\Exception\FilterException;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Session\SessionManager;

class DiscussionController extends AbstractController
{
    private $template;
    private $router;
    private $discussionService;
    private $session;

    public function __construct(Template $template, Router $router, DiscussionService $discussionService, SessionManager $session)
    {
        $this->template          = $template;
        $this->router            = $router;
        $this->discussionService = $discussionService;
        $this->session           = $session;
    }

    public function index() : \Psr\Http\Message\ResponseInterface
    {
        $params = $this->request->getQueryParams();
        $page   = isset($params['page']) ? $params['page'] : 1;
        $limit  = isset($params['limit']) ? $params['limit'] : 15;

        $discussions = $this->discussionService->fetchAllArticles($page, $limit);

        return new HtmlResponse($this->template->render('admin::discussion/index', ['list' => $discussions]));
    }

    public function edit(): \Psr\Http\Message\ResponseInterface
    {
        $id   = $this->request->getAttribute('id');
        $post = $this->discussionService->fetchSingleArticle($id);

        return new HtmlResponse($this->template->render('admin::discussion/edit', ['discussion' => $post]));
    }

    public function doedit()
    {
        try{
            $id   = $this->request->getAttribute('id');
            $data = $this->request->getParsedBody();
            $user = $this->session->getStorage()->user;

            $this->discussionService->saveArticle($user, $data, $id);
        }
        catch(FilterException $fe){
            var_dump($fe->getArrayMessages());
            throw $fe;
        }
        catch(\Exception $e){
            throw $e;
        }

        return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.discussions'));
    }

    public function delete()
    {
        try{
            $this->discussionService->deleteArticle($this->request->getAttribute('id'));
        }
        catch(\Exception $e){
            throw $e;
        }

        return $this->response->withStatus(302)->withHeader(
            'Location', $this->router->generateUri('admin.discussions')
        );
    }
}
