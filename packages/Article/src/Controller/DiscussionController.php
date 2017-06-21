<?php

declare(strict_types=1);

namespace Article\Controller;

use Core\Controller\AbstractController;
use Article\Service\DiscussionService;
use Category\Service\CategoryService;
use Core\Exception\FilterException;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Session\SessionManager;

class DiscussionController extends AbstractController
{
    /**
* 
     *
 * @var Template 
*/
    private $template;

    /**
* 
     *
 * @var Router 
*/
    private $router;

    /**
* 
     *
 * @var DiscussionService 
*/
    private $discussionService;

    /**
* 
     *
 * @var SessionManager 
*/
    private $session;

    /**
* 
     *
 * @var CategoryService 
*/
    private $categoryService;
    
    /**
     * DiscussionController constructor.
     *
     * @param Template          $template
     * @param Router            $router
     * @param DiscussionService $discussionService
     * @param SessionManager    $session
     * @param CategoryService   $categoryService
     */
    public function __construct(Template $template, Router $router, DiscussionService $discussionService,
        SessionManager $session, CategoryService $categoryService
    ) {
    
        $this->template          = $template;
        $this->router            = $router;
        $this->discussionService = $discussionService;
        $this->session           = $session;
        $this->categoryService   = $categoryService;
    }

    /**
     * Displays a list of discussions.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(): \Psr\Http\Message\ResponseInterface
    {
        $params = $this->request->getQueryParams();
        $page   = isset($params['page']) ? $params['page'] : 1;
        $limit  = isset($params['limit']) ? $params['limit'] : 15;

        $discussions = $this->discussionService->fetchAllArticles($page, $limit);

        return new HtmlResponse($this->template->render('article::discussion/index', ['list' => $discussions, 'layout' => 'layout/admin']));
    }

    /**
     * Displays a discussion edit form, with data from request, if any.
     *
     * @param array $errors errors for displaying to user
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function edit($errors = []): \Psr\Http\Message\ResponseInterface
    {
        $id         = $this->request->getAttribute('id');
        $discussion = $this->discussionService->fetchSingleArticle($id);
        $categories = $this->categoryService->getAll();

        if($this->request->getParsedBody()) {
            $discussion             = (object)($this->request->getParsedBody() + (array)$discussion);
            $discussion->article_id = $id;
        }

        return new HtmlResponse(
            $this->template->render(
                'article::discussion/edit', [
                'discussion' => $discussion,
                'categories' => $categories,
                'errors'     => $errors,
                'layout'     => 'layout/admin'
                ]
            )
        );
    }

    public function save()
    {
        try {
            $id   = $this->request->getAttribute('id');
            $data = $this->request->getParsedBody();
            $user = $this->session->getStorage()->user;

            if($id) {
                $this->discussionService->updateArticle($data, $id);
            } else {
                $this->discussionService->createArticle($user, $data);
            }
        }
        catch(FilterException $fe) {
            return $this->edit($fe->getArrayMessages());
        }
        catch(\Exception $e) {
            throw $e;
        }

        return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.discussions'));
    }

    public function delete()
    {
        try {
            $this->discussionService->deleteArticle($this->request->getAttribute('id'));
        }
        catch(\Exception $e) {
            throw $e;
        }

        return $this->response->withStatus(302)->withHeader(
            'Location', $this->router->generateUri('admin.discussions')
        );
    }
}
