<?php
declare(strict_types = 1);
namespace Article\Controller;

use Std\AbstractController;
use Article\Service\EventService;
use Std\FilterException;
use Category\Service\CategoryService;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Session\SessionManager;
use Zend\Http\PhpEnvironment\Request;
use Article\Entity\ArticleType;

class EventController extends AbstractController
{
    private $template;
    private $router;
    private $eventService;
    private $session;
    private $categoryService;

    /**
     * EventController constructor.
     * @param Template $template
     * @param Router $router
     * @param EventService $eventService
     * @param SessionManager $session
     * @param CategoryService $categoryService
     */
    public function __construct(
        Template $template,
        Router $router,
        EventService $eventService,
        SessionManager $session,
        CategoryService $categoryService
    ) {
        $this->template = $template;
        $this->router = $router;
        $this->eventService = $eventService;
        $this->session = $session;
        $this->categoryService = $categoryService;
    }

    public function index(): \Psr\Http\Message\ResponseInterface
    {
        $params = $this->request->getQueryParams();
        $page = isset($params['page']) ? $params['page'] : 1;
        $limit = isset($params['limit']) ? $params['limit'] : 15;
        $events = $this->eventService->fetchAllArticles($page, $limit);

        return new HtmlResponse($this->template->render(
            'article::event/index',
            ['list' => $events, 'layout' => 'layout/admin'])
        );
    }

    public function edit($errors = []): \Psr\Http\Message\ResponseInterface
    {
        $id = $this->request->getAttribute('id');
        $event = $this->eventService->fetchSingleArticle($id);
        $categories = $this->categoryService->getAll(ArticleType::EVENT);

        if ($this->request->getParsedBody()) {
            $event = (object)($this->request->getParsedBody() + (array)$event);
            $event->article_id = $id;
        }

        return new HtmlResponse(
            $this->template->render(
                'article::event/edit', [
                    'event' => $event,
                    'categories' => $categories,
                    'errors' => $errors,
                    'layout' => 'layout/admin'
                ]
            )
        );
    }

    public function save()
    {
        try {
            $id = $this->request->getAttribute('id');
            $user = $this->session->getStorage()->user;
            $data = $this->request->getParsedBody();
            $data += (new Request())->getFiles()->toArray();

            if ($id) {
                $this->eventService->updateArticle($data, $id);
            } else {
                $this->eventService->createArticle($user, $data);
            }
        } catch (FilterException $fe) {
            return $this->edit($fe->getArrayMessages());
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.events'));
    }

    public function delete()
    {
        try {
            $this->eventService->deleteArticle($this->request->getAttribute('id'));
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->response->withStatus(302)->withHeader(
            'Location', $this->router->generateUri('admin.events')
        );
    }
}
