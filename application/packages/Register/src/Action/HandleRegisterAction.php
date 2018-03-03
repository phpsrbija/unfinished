<?php

declare(strict_types=1);

namespace Register\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Register\Service\RegisterService;
use Std\FilterException;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class HandleRegisterAction.
 */
class HandleRegisterAction
{
    private $template;
    private $registerService;

    public function __construct(RegisterService $registerService, Template $template)
    {
        $this->registerService = $registerService;
        $this->template        = $template;
    }

    /**
     * Page to show form for register.
     * On error show same form with errors.
     * On success show congrats page.
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $next
     *
     * @return HtmlResponse
     * @throws \Exception
     *
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $data = $request->getParsedBody();

        try {
            $this->registerService->handleRegistration($data);

            return new HtmlResponse($this->template->render('register::congrats', ['layout' => 'layout/web']));
        } catch (FilterException $fe) {

            return new HtmlResponse($this->template->render('register::index', [
                'exception' => null,
                'data'      => $data,
                'errors'    => $fe->getArrayMessages(),
                'layout'    => 'layout/web'
            ]));
        } catch (\Exception $e) {
            error_log($e->getMessage());

            return new HtmlResponse($this->template->render('register::index', [
                'data'      => $data,
                'exception' => 'Something went wrong, please contact us at pr@phpsrbija.rs',
                'errors'    => null,
                'layout'    => 'layout/web'
            ]));
        }

    }
}
