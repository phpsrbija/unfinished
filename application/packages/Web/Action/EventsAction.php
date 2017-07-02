<?php

declare(strict_types=1);

namespace Web\Action;

use Article\Entity\ArticleType;
use Article\Service\EventService;
use Category\Service\CategoryService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as Template;

/**
 * Class EventsAction.
 */
class EventsAction
{
    /** @var Template */
    private $template;

    /** @var EventService */
    private $eventService;

    /** @var CategoryService */
    private $categoryService;

    /**
     * EventsAction constructor.
     *
     * @param Template        $template
     * @param EventService    $eventService
     * @param CategoryService $categoryService
     */
    public function __construct(
        Template $template,
        EventService $eventService,
        CategoryService $categoryService
    ) {
        $this->template = $template;
        $this->eventService = $eventService;
        $this->categoryService = $categoryService;
    }

    /**
     * Executed when action is invoked.
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $next
     *
     * @throws \Exception
     *
     * @return HtmlResponse
     */
    public function __invoke(
        Request $request,
        Response $response,
        callable $next = null
    ) {
        $params = $request->getQueryParams();
        $page = isset($params['page']) ? $params['page'] : 1;
        $urlSlug = $request->getAttribute('category');
        $category = $this->categoryService->getCategoryBySlug($urlSlug);

        if (!$category || $category->type != ArticleType::EVENT) {
            return $next($request, $response);
        }

        $futureEvents = $this->eventService->fetchFutureEvents();
        $pastEvents = $this->eventService->fetchPastEventsPagination($page, 10);

        return new HtmlResponse($this->template->render('web::events', [
            'layout'       => 'layout/web',
            'futureEvents' => $futureEvents,
            'pastEvents'   => $pastEvents,
            'category'     => $category,
        ]));
    }
}
