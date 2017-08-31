<?php

namespace Web\Action;

use ContactUs\Service\ContactUsService;
use Std\FilterException;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class ContactUsAction
 *
 * @package Web\Action
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class ContactUsAction
{
    /**
     * @var Template $template
     */
    protected $template;

    /**
     * @var ContactUsService $contactUsService
     */
    protected $contactUsService;

    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * ContactUsAction constructor.
     *
     * @param Template          $template
     * @param ContactUsService  $contactUsService
     * @param RouterInterface   $router
     */
    public function __construct(
        Template         $template,
        ContactUsService $contactUsService,
        RouterInterface  $router)
    {
        $this->template = $template;
        $this->contactUsService = $contactUsService;
    }

    /**
     * Executed when action is invoked.
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable      $next
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        return new HtmlResponse($this->template->render('web::contact', [
            'layout' => 'layout/web'
        ]));
    }

    /**
     * @param   Request   $request
     * @param   Response  $response
     *
     * @return  Response
     *
     * @throws  FilterException
     * @throws \Exception
     */
    public function post(Request $request, Response $response)
    {
        $data = $request->getAttributes();
        if (!empty($data)) {
            try
            {
                $this->contactUsService->create($data);
                return $response
                    ->withStatus(200)
                    ->withHeader('Location', $this->router->generateUri('contact-us'))
                ;

            } catch (FilterException $fe) {

                return $response
                    ->withStatus(302)
                    ->withHeader('Location', $this->router->generateUri('contact-us'))
                ;

            } catch (\Exception $e) {
                throw $e;
            }
        }
    }
}