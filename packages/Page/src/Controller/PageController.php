<?php

namespace Page\Controller;

use Std\AbstractController;
use Std\FilterException;
use Page\Service\PageService;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Http\PhpEnvironment\Request;

class PageController extends AbstractController
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
     * @var PageService
     */
    private $pageService;

    /**
     * PageController constructor.
     *
     * @param Template    $template
     * @param Router      $router
     * @param PageService $pageService
     */
    public function __construct(Template $template, Router $router, PageService $pageService)
    {
        $this->template    = $template;
        $this->router      = $router;
        $this->pageService = $pageService;
    }

    /**
     * @return HtmlResponse
     */
    public function index(): HtmlResponse
    {
        $params     = $this->request->getQueryParams();
        $page       = isset($params['page']) ? $params['page'] : 1;
        $limit      = isset($params['limit']) ? $params['limit'] : 15;
        $pagination = $this->pageService->getPagination($page, $limit);

        return new HtmlResponse(
            $this->template->render(
                'page::index', [
                'pagination' => $pagination,
                'layout'     => 'layout/admin'
                ]
            )
        );
    }

    public function edit($errors = []): HtmlResponse
    {
        $id   = $this->request->getAttribute('id');
        $page = $this->pageService->getPage($id);

        if($this->request->getParsedBody()) {
            $page = new \Page\Entity\Page();
            $page->exchangeArray($this->request->getParsedBody() + (array)$page);
        }

        return new HtmlResponse(
            $this->template->render(
                'page::edit', [
                'page'   => $page,
                'errors' => $errors,
                'layout' => 'layout/admin'
                ]
            )
        );
    }

    public function save(): \Psr\Http\Message\ResponseInterface
    {
        try {
            $pageId = $this->request->getAttribute('id');
            $data = $this->request->getParsedBody();
            $data += (new Request())->getFiles()->toArray();

            if ($pageId) {
                $this->pageService->updatePage($data, $pageId);
            } else {
                $this->pageService->createPage($data);
            }

            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.pages'));
        } catch (FilterException $fe) {
            return $this->edit($fe->getArrayMessages());
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function delete(): \Psr\Http\Message\ResponseInterface
    {
        try {
            $pageId = $this->request->getAttribute('id');
            $this->pageService->delete($pageId);

            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.pages'));
        } catch (\Exception $e) {
            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.pages'));
        }
    }
}
