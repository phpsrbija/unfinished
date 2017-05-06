<?php
declare(strict_types = 1);

namespace Menu\Controller;

use Menu\Service\MenuService;
use Core\Exception\FilterException;
use Zend\Diactoros\Response\JsonResponse;
use Admin\Controller\AbstractController;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Diactoros\Response\HtmlResponse;

class IndexController extends AbstractController
{
    /** @var Template */
    private $template;

    /** @var Router */
    private $router;

    /** @var MenuService */
    private $menuService;

    public function __construct(Template $template, Router $router, MenuService $menuService)
    {
        $this->template    = $template;
        $this->router      = $router;
        $this->menuService = $menuService;
    }

    public function index()
    {
        return new HtmlResponse($this->template->render('menu::index/index', [
            'menuNestedItems' => $this->menuService->getNestedAll(),
            'layout'          => 'layout/admin'
        ]));
    }

    public function edit($errors = [])
    {
        $id   = $this->request->getAttribute('id');
        $item = $this->menuService->get($id);

        if($this->request->getParsedBody()){
            $item          = (object)($this->request->getParsedBody() + (array)$item);
            $item->menu_id = $id;
        }

        return new HtmlResponse($this->template->render('menu::index/edit', [
            'id'        => $id,
            'item'      => $item,
            'menuItems' => $this->menuService->getForSelect(),
            'errors'    => $errors,
            'layout'    => 'layout/admin'
        ]));
    }

    public function save()
    {
        try{
            $id   = $this->request->getAttribute('id');
            $data = $this->request->getParsedBody();

            if($id){
                $this->menuService->updateMenuItem($data, $id);
            }
            else{
                $this->menuService->addMenuItem($data);
            }

            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.menu'));
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
            $this->menuService->delete($id);

            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin.menu'));
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function updateOrder()
    {
        $data      = $this->request->getParsedBody();
        $menuOrder = isset($data['order']) ? json_decode($data['order']) : [];
        $status    = $this->menuService->updateMenuOrder($menuOrder);

        return new JsonResponse(['status' => $status]);
    }
}