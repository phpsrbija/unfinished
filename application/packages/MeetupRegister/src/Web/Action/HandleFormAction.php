<?php

declare(strict_types=1);

namespace MeetupRegister\Web\Action;

use MeetupRegister\Service\RegisterService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Std\FilterException;

class HandleFormAction
{
    private $registerService;

    private $router;

    private $template;

    public function __construct(RegisterService $registerService, Router $router, Template $template)
    {
        $this->registerService = $registerService;
        $this->router = $router;
        $this->template = $template;
    }

    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $success = false;
        $errors = false;
        try {
            $data = $request->getParsedBody();
            $data['clientIp'] = $request->getServerParams()['REMOTE_ADDR'];
            $this->registerService->sendNotice($data);
            $success = true;
        } catch (FilterException $e) {
            $errors = \GuzzleHttp\json_decode($e->getMessage());
        } catch (\Exception $e) {
            $errors = new \stdClass();
            $errors->captcha = $e->getMessage();
        }

        return new HtmlResponse($this->template->render('meetupregister::form', [
            'layout'    => 'layout/web',
            'success'   => $success,
            'errors'   => $errors
        ]));
    }
}
