<?php

declare(strict_types=1);

namespace Web\Action;

use Article\Service\EventService;
use Category\Service\CategoryService;
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
     */
    public function __construct(Template $template, EventService $eventService, CategoryService $categoryService)
    {
        $this->template        = $template;
        $this->eventService    = $eventService;
        $this->categoryService = $categoryService;
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
        $eventId = $request->getAttribute('event_id');
        $event   = $this->eventService->fetchSingleArticle($eventId);

        return new HtmlResponse($this->template->render('web::event', [
            'layout' => 'layout/web',
            'event'  => $event
        ]));
    }

}
