<?php

namespace ContactUs\Controller;

use ContactUs\Entity\ContactUs;
use ContactUs\Service\ContactUsService;
use Std\FilterException;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Psr\Http\Message\ResponseInterface;
use Std\AbstractController;

/**
 * Class ContactUsController
 *
 * @package ContactUs
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class ContactUsController extends AbstractController
{
    /**
     * @var \Zend\Expressive\Router\RouterInterface $router
     */
    protected $router;

    /**
     * @var \Zend\Expressive\Template\TemplateRendererInterface $template
     */
    protected $template;

    /**
     * @var \ContactUs\Service\ContactUsService $contactUsService
     */
    protected $contactUsService;

    /**
     * ContactUsController constructor.
     *
     * @param Template          $template
     * @param Router            $router
     * @param ContactUsService  $contactUsService
     */
    public function __construct(Template $template, Router $router, ContactUsService $contactUsService)
    {
        $this->template = $template;
        $this->router = $router;
        $this->contactUsService = $contactUsService;
    }

    /**
     * @return HtmlResponse
     */
    public function index(): HtmlResponse
    {
        $params     = $this->request->getQueryParams();
        $page       = isset($params['page'])  ? $params['page']  : 1;
        $limit      = isset($params['limit']) ? $params['limit'] : 15;
        $pagination = $this->contactUsService->getPagination($page, $limit);

        return new HtmlResponse(
            $this->template->render(
                'contact-us::index', [
                    'pagination' => $pagination,
                    'layout'     => 'layout/admin',
                ]
            )
        );
    }

    /**
     * @param array $errors
     *
     * @return HtmlResponse
     */
    public function edit($errors = []): HtmlResponse
    {
        $id        = $this->request->getAttribute('id');
        $contactUs = $this->contactUsService->getById($id);

        if ($this->request->getParsedBody()) {
            $contactUs = new ContactUs();
            $contactUs->exchangeArray(
                $this->request->getParsedBody() + (array) $contactUs
            );
            $contactUs->setContactId($id);
        }

        return new HtmlResponse(
            $this->template->render(
                'contact-us::edit', [
                    'contact'   => $contactUs,
                    'errors'    => $errors,
                    'layout'    => 'layout/admin',
                ]
            )
        );
    }

    /**
     * @return ResponseInterface
     *
     * @throws \Exception
     */
    public function save(): ResponseInterface
    {
        try
        {
            $id   = $this->request->getAttribute('id');
            $data = $this->request->getParsedBody();

            if ($id) {
                $this->contactUsService->update($data, $id);
            } else {
                $this->contactUsService->create($data);
            }

            return $this->response
                ->withStatus(302)
                ->withHeader('Location', $this->router->generateUri('admin.contact-us'))
            ;

        } catch (FilterException $fe) {
            return $this->edit($fe->getArrayMessages());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return ResponseInterface
     */
    public function delete(): ResponseInterface
    {
        try
        {
            $id = $this->request->getAttribute('id');
            $this->contactUsService->delete($id);

            return $this->response
                ->withStatus(302)
                ->withHeader('Location', $this->router->generateUri('admin.contact-us'))
            ;

        } catch (\Exception $e) {
            return $this->response
                ->withStatus(302)
                ->withHeader('Location', $this->router->generateUri('admin.contact-us'))
            ;
        }
    }
}