<?php

declare(strict_types=1);

namespace Article\Controller;

use Std\AbstractController;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;
use Article\Service\VideoService;
use Category\Service\CategoryService;
use Zend\Session\SessionManager;
use Zend\Expressive\Router\RouterInterface as Router;
use Std\FilterException;
use Zend\Http\PhpEnvironment\Request;

class VideoController extends AbstractController
{
    /**
     * @var Template
     */
    private $template;

    /**
     * @var VideoService
     */
    private $videoService;

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
     * VideoController constructor.
     *
     * @param Template        $template
     * @param Router          $router
     * @param VideoService    $videoService
     * @param SessionManager  $session
     * @param CategoryService $categoryService
     */
    public function __construct(
        Template $template,
        Router $router,
        VideoService $videoService,
        SessionManager $session,
        CategoryService $categoryService
    ) {
    
        $this->template        = $template;
        $this->videoService    = $videoService;
        $this->session         = $session;
        $this->router          = $router;
        $this->categoryService = $categoryService;
    }

    public function index(): HtmlResponse
    {
        $params = $this->request->getQueryParams();
        $page   = isset($params['page']) ? $params['page'] : 1;
        $limit  = isset($params['limit']) ? $params['limit'] : 15;
        $videos = $this->videoService->fetchAllArticles($page, $limit);

        return new HtmlResponse($this->template->render('article::video/index', ['list' => $videos, 'layout' => 'layout/admin']));
    }

    /**
     * Add/Edit show form
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function edit($errors = []): \Psr\Http\Message\ResponseInterface
    {
        $id         = $this->request->getAttribute('id');
        $video      = $this->videoService->fetchSingleArticle($id);
        $categories = $this->categoryService->getAll();

        if($this->request->getParsedBody()) {
            $video             = (object)($this->request->getParsedBody() + (array)$video);
            $video->article_id = $id;
        }

        return new HtmlResponse(
            $this->template->render(
                'article::video/edit', [
                'video'      => $video,
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
    public function save(): \Psr\Http\Message\ResponseInterface
    {
        try {
            $id   = $this->request->getAttribute('id');
            $user = $this->session->getStorage()->user;
            $data = $this->request->getParsedBody();
            $data += (new Request())->getFiles()->toArray();

            if($id) {
                $this->videoService->updateArticle($data, $id);
            } else {
                $this->videoService->createArticle($user, $data);
            }
        }
        catch(FilterException $fe) {
            return $this->edit($fe->getArrayMessages());
        }
        catch(\Exception $e) {
            throw $e;
        }

        return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.videos'));
    }

    /**
     * Delete video by id.
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function delete(): \Psr\Http\Message\ResponseInterface
    {
        try {
            $this->videoService->deleteArticle($this->request->getAttribute('id'));
        }
        catch(\Exception $e) {
            throw $e;
        }

        return $this->response->withStatus(302)->withHeader(
            'Location', $this->router->generateUri('admin.videos', ['action' => 'index'])
        );
    }
}
