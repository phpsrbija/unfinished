<?php

declare(strict_types = 1);

namespace Admin\Controller;

use Core\Service\TagService;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class TagController.
 *
 * @package Admin\Controller
 */
class TagController extends AbstractController
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
     * @var TagService
     */
    private $tagService;

    /**
     * TagController constructor.
     *
     * @param Template $template template engine
     */
    public function __construct(Template $template, Router $router, TagService $tagService)
    {
        $this->template   = $template;
        $this->router     = $router;
        $this->tagService = $tagService;
    }

    /**
     * Tags list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index() : \Psr\Http\Message\ResponseInterface
    {
        $params = $this->request->getQueryParams();
        $page   = isset($params['page']) ? $params['page'] : 1;
        $limit  = isset($params['limit']) ? $params['limit'] : 15;

        $tags = $this->tagService->getPagination($page, $limit);

        return new HtmlResponse($this->template->render('admin::tag/index', ['list' => $tags]));
    }

    /**
     * Edit one user by givven UUID from route.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function edit(): \Psr\Http\Message\ResponseInterface
    {
        $id  = $this->request->getAttribute('id');
        $tag = $this->tagService->getTag($id);

        return new HtmlResponse($this->template->render('admin::tag/edit', ['tag' => $tag]));
    }

    public function doedit()
    {
        try{
            $id   = $this->request->getAttribute('id');
            $data = $this->request->getParsedBody();

            $this->tagService->save($data, $id);

            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.tags'));
        }
        catch(\Exception $e){
            return $this->response->withStatus(302)->withHeader(
                'Location',
                $this->router->generateUri('admin.tags.action', ['action' => 'edit', 'id' => $id])
            );
        }
    }

    public function delete()
    {
        try{
            $id = $this->request->getAttribute('id');
            $this->tagService->delete($id);

            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.tags'));
        }
        catch(\Exception $e){
            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.tags'));
        }
    }
}
