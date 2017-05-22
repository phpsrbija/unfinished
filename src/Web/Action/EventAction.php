<?php

declare(strict_types=1);

namespace Web\Action;

use Article\Service\EventService;
use Category\Service\CategoryService;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class EventAction.
 *
 * @package Web\Action
 */
class EventAction
{
    /** @var Template */
    private $template;

    /** @var EventService */
    private $eventService;

    /** @var CategoryService */
    private $categoryService;

    /**
     * EventAction constructor.
     *
     * @param Template $template
     * @param EventService $eventService
     * @param CategoryService $categoryService
     * @param Client $httpClient
     */
    public function __construct(
        Template $template,
        EventService $eventService,
        CategoryService $categoryService,
        Client $httpClient
    ) {
        $this->template        = $template;
        $this->eventService    = $eventService;
        $this->categoryService = $categoryService;
        $this->httpClient      = $httpClient;
    }

    /**
     * Executed when action is invoked
     *
     * @param Request $request
     * @param Response $response
     * @param callable|null $next
     * @return HtmlResponse
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $eventSlug = $request->getAttribute('event_slug');
        $event     = $this->eventService->fetchEventBySlug($eventSlug);

        return new HtmlResponse($this->template->render('web::event', [
            'layout' => 'layout/web',
            'event'  => $event
        ]));
    }

}
