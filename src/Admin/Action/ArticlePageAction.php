<?php
declare(strict_types = 1);

namespace Admin\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as Template;

/**
 * Class ArticlePageAction.
 * This class is responsible for all article crud pages.
 *
 * @package Admin\Action
 */
class ArticlePageAction extends AbstractPage
{
    /**
     * @var \Admin\Model\Repository\ArticleRepositoryInterface
     */
    private $articleRepo;

    /**
     * @var \Zend\Validator\AbstractValidator
     */
    private $validator;

    public function __construct(
        Template $template,
        \Admin\Model\Repository\ArticleRepositoryInterface $articleRepo,
        \Admin\Validator\ValidatorInterface $validator
    ) {
        parent::__construct($template);

        $this->articleRepo = $articleRepo;
        $this->validator = $validator;
    }

    public function indexAction(Request $request, Response $response, callable $next = null) : HtmlResponse
    {
        $data = [
            'message'    => 'Article list',
            'additional' => '*',
        ];

        return new HtmlResponse($this->getTemplate()->render('admin::article/index', $data));
    }

    public function createAction(Request $request, Response $response) : HtmlResponse
    {
        $data = [
            'message' => 'Create article',
            'errors' => false,
            'data' => $request->getParsedBody()
        ];

        if (count($data['data']) > 0) {
            try {
                $article = new \Admin\Model\Entity\ArticleEntity();
                $this->validator->validate($data['data']);

                $article->exchangeArray($data['data']);
                //@TODO implement storage interface
//                var_dump($this->articleRepo->saveArticle($article));
//                var_dump($article);

            // handle validation errors
            } catch (\Admin\Validator\ValidatorException $e) {
                $data['errors'] = $this->validator->getMessages();

            // handle other errors
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }
        }

        return new HtmlResponse($this->getTemplate()->render('admin::article/create', $data));
    }
}