<?php
declare(strict_types = 1);
namespace Core\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class Error.
 *
 * @package Core\Middleware
 */
final class Error
{
    /**
     * @var Template
     */
    private $template;

    /**
     * Error constructor.
     *
     * @param Template $template template
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Invoked on middleware execution.
     *
     * @param mixed $exception   exception
     * @param Request $request   request
     * @param Response $response response
     * @return HtmlResponse
     */
    public function __invoke($ex, Request $request, Response $response) : HtmlResponse
    {
        if ($ex instanceof \Exception) {
            $code    = $ex->getCode() === 0 ? 500 : $ex->getCode();
            $message = $ex->getMessage();
        } elseif (is_int($ex)) {
            $code    = $ex;
            $message = 'Application Error!';
        } else {
            $code    = 500;
            $message = 'Unknown Application Error!';
        }

        return new HtmlResponse($this->template->render('error::error', [
            'exception' => $ex,
            'status'    => $code,
            'reason'    => $message,
            'layout'    => 'layout/no'
        ]), $code);
    }
}
