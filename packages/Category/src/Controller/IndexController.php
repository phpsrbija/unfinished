<?php

declare(strict_types = 1);

namespace Category\Controller;

use Category\Service\CategoryService;
use Core\Exception\FilterException;
use Core\Controller\AbstractController;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Http\PhpEnvironment\Request;

/**
 * Class IndexController.
 *
 * @package Category\Controller
 */
class IndexController extends AbstractController
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
 * @var CategoryService 
*/
    private $categoryService;

    /**
     * IndexController constructor.
     *
     * @param Template $template template engine
     */
    public function __construct(Template $template, Router $router, CategoryService $categoryService)
    {
        $this->template        = $template;
        $this->router          = $router;
        $this->categoryService = $categoryService;
    }

    /**
     * Category list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index() : \Psr\Http\Message\ResponseInterface
    {
        $params = $this->request->getQueryParams();
        $page   = isset($params['page']) ? $params['page'] : 1;
        $limit  = isset($params['limit']) ? $params['limit'] : 15;

        $categories = $this->categoryService->getPagination($page, $limit);

        return new HtmlResponse($this->template->render('category::index/index', ['list' => $categories, 'layout' => 'layout/admin']));
    }

    /**
     * Edit one user by givven UUID from route.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function edit($errors = []): \Psr\Http\Message\ResponseInterface
    {
        $id       = $this->request->getAttribute('id');
        $category = $this->categoryService->getCategory($id);

        if($this->request->getParsedBody()) {
            $category              = (object)($this->request->getParsedBody() + (array)$category);
            $category->category_id = $id;
        }

        return new HtmlResponse(
            $this->template->render(
                'category::index/edit', [
                'category' => $category,
                'errors'   => $errors,
                'layout'   => 'layout/admin'
                ]
            )
        );
    }

    public function save()
    {
        try{
            $id   = $this->request->getAttribute('id');
            $data = $this->request->getParsedBody();
            $data += (new Request())->getFiles()->toArray();

            if($id) {
                $this->categoryService->updateCategory($data, $id);
            }
            else{
                $this->categoryService->createCategory($data);
            }

            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.categories'));
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
            $this->categoryService->delete($id);

            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.categories'));
        }
        catch(\Exception $e){
            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.categories'));
        }
    }
}
