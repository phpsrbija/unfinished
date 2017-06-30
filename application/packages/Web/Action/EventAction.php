<?php

declare(strict_types = 1);

namespace Web\Action;

use Article\Service\EventService;
use Article\Entity\ArticleType;
use Category\Service\CategoryService;
use Meetup\MeetupApiService;
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

    /** @var MeetupApiService */
    private $meetupService;

    /**
     * EventAction constructor.
     *
     * @param Template         $template
     * @param EventService     $eventService
     * @param CategoryService  $categoryService
     * @param MeetupApiService $meetupService
     */
    public function __construct(
        Template $template,
        EventService $eventService,
        CategoryService $categoryService,
        MeetupApiService $meetupService
    ) {
        $this->template        = $template;
        $this->eventService    = $eventService;
        $this->categoryService = $categoryService;
        $this->meetupService   = $meetupService;
    }

    /**
     * Executed when action is invoked
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $next
     *
     * @return HtmlResponse
     * @throws \Exception
     */
    public function __invoke(
        Request $request,
        Response $response,
        callable $next = null
    ) {
        $categorySlug = $request->getAttribute('segment_1');
        $eventSlug    = $request->getAttribute('segment_2');
        $event        = $this->eventService->fetchEventBySlug($eventSlug);

        if (!$event || $event->type != ArticleType::EVENT) {
            return $next($request, $response);
        }

        // Fetch going ppl
        $attendees = $this->meetupService->getAttendees($event->event_url);

        return new HtmlResponse($this->template->render('web::event', [
            'layout'    => 'layout/web',
            'event'     => $event,
            'attendees' => $attendees
        ]));
    }
}
