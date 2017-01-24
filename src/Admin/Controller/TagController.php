<?php

declare(strict_types = 1);

namespace Admin\Controller;

use Core\Service\TagService;
use Core\Exception\FilterException;
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
    public function edit($errors = []): \Psr\Http\Message\ResponseInterface
    {
        $id  = $this->request->getAttribute('id');
        $tag = $this->tagService->getTag($id);

        if($this->request->getParsedBody()){
            $tag         = (object)($this->request->getParsedBody() + (array)$tag);
            $tag->tag_id = $id;
        }

        return new HtmlResponse($this->template->render('admin::tag/edit', ['tag' => $tag, 'errors' => $errors]));
    }

    public function save()
    {
        try{
            $id   = $this->request->getAttribute('id');
            $data = $this->request->getParsedBody();

            if($id){
                $this->tagService->updateTag($data, $id);
            }
            else{
                $this->tagService->createTag($data);
            }

            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.tags'));
        }
        catch(FilterException $fe){
            return $this->edit($fe->getArrayMessages());
        }
        catch(\Exception $e){
            throw $e;
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
