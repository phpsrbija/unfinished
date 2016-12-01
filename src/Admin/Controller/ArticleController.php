<?php

namespace Admin\Controller;

use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;
use Admin\Model\Repository\ArticleRepositoryInterface;
use Admin\Validator\ValidatorInterface as Validator;
use Ramsey\Uuid\Uuid;

class ArticleController extends AbstractController
{
    /**
     * @var Template
     */
    private $template;

    /**
     * @var \Admin\Model\Repository\ArticleRepositoryInterface
     */
    private $articleRepo;

    /**
     * @var \Zend\Validator\AbstractValidator
     */
    private $validator;

    /**
     * ArticleController constructor.
     *
     * @param Template $template
     * @param ArticleRepositoryInterface $articleRepo
     * @param Validator $validator
     */
    public function __construct(Template $template, ArticleRepositoryInterface $articleRepo, Validator $validator)
    {
        $this->template = $template;
        $this->articleRepo = $articleRepo;
        $this->validator = $validator;
    }

    public function index() : HtmlResponse
    {
        $articleCollection = $this->articleRepo->fetchAllArticles();

        $data = [
            'message'    => 'Article list',
            'articleCollection' => $articleCollection,
        ];

        return new HtmlResponse($this->template->render('admin::article/index', $data));
    }

    public function create() : HtmlResponse
    {
        $data = [
            'message' => 'Create article',
            'errors' => false,
            'data' => $this->request->getParsedBody()
        ];

        if (count($data['data']) > 0) {
            try {
                $article = new \Admin\Model\Entity\ArticleEntity();
                //generate uuid
                $data['data']['article_uuid'] = Uuid::uuid1()->toString();
                $this->validator->validate($data['data']);

                $article->exchangeArray($data['data']);
                var_dump($this->articleRepo->saveArticle($article));
                die();
                if ($this->articleRepo->saveArticle($article)) {
                    return $this->index();
                }
                //@TODO there was an error saving article, set a flesh message for user

                // handle validation errors
            } catch (\Admin\Validator\ValidatorException $e) {
                $data['errors'] = $this->validator->getMessages();

                // handle other errors
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }
        }

        return new HtmlResponse($this->template->render('admin::article/create', $data));
    }
}