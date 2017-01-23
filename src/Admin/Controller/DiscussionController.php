<?php

declare(strict_types = 1);

namespace Admin\Controller;

use Core\Service\Article\DiscussionService;
use Core\Service\TagService;
use Core\Exception\FilterException;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Session\SessionManager;

class DiscussionController extends AbstractController
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
     * @var DiscussionService
     */
    private $discussionService;

    /**
     * @var SessionManager
     */
    private $session;
    /**
     * @var TagService
     */
    private $tagService;

    /**
     * DiscussionController constructor.
     *
     * @param Template $template
     * @param Router $router
     * @param DiscussionService $discussionService
     * @param SessionManager $session
     * @param TagService $tagService
     */
    public function __construct(Template $template, Router $router, DiscussionService $discussionService,
                                SessionManager $session, TagService $tagService)
    {
        $this->template          = $template;
        $this->router            = $router;
        $this->discussionService = $discussionService;
        $this->session           = $session;
        $this->tagService        = $tagService;
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
        $id         = $this->request->getAttribute('id');
        $discussion = $this->discussionService->fetchSingleArticle($id);
        $tags       = $this->tagService->getAll();

        return new HtmlResponse($this->template->render('admin::discussion/edit', ['discussion' => $discussion, 'tags' => $tags]));
    }

    public function save()
    {
        try{
            $id   = $this->request->getAttribute('id');
            $data = $this->request->getParsedBody();
            $user = $this->session->getStorage()->user;

            if($id){
                $this->discussionService->updateArticle($data, $id);
            }
            else{
                $this->discussionService->createArticle($user, $data);
            }
        }
        catch(FilterException $fe){
            $messages = $fe->getArrayMessages();
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
