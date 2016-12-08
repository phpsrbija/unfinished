<?php

namespace Admin\Controller;

use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;
use Admin\Model\Repository\ArticleRepositoryInterface;
use Admin\Validator\ValidatorInterface as Validator;
use Ramsey\Uuid\Uuid;
use Zend\Session\SessionManager;
use Zend\Expressive\Router\RouterInterface as Router;

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
     * @var SessionManager
     */
    private $session;

    /**
     * @var ROUTER
     */
    private $router;

    /**
     * ArticleController constructor.
     *
     * @param Template $template
     * @param ArticleRepositoryInterface $articleRepo
     * @param Validator $validator
     * @param SessionManager $session
     * @param Router $routes
     */
    public function __construct(
        Template $template,
        ArticleRepositoryInterface $articleRepo,
        Validator $validator,
        SessionManager $session,
        Router $router
    ) {
        $this->template = $template;
        $this->articleRepo = $articleRepo;
        $this->validator = $validator;
        $this->session = $session;
        $this->router = $router;
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

    public function create() : \Psr\Http\Message\ResponseInterface
    {
        $data = [
            'message' => 'Create article',
            'errors' => false,
            'data' => $this->request->getParsedBody()
        ];

        if (count($data['data']) > 0) {
            $user   = $this->session->getStorage()->user;
            try {
                $article = new \Admin\Model\Entity\ArticleEntity();
                //@TODO fix this
                $dt = new \DateTime('now');
                $data['data']['created_at'] = $dt->format('Y-m-d H:i:s');

                //generate uuid
                $data['data']['article_uuid'] = hex2bin(Uuid::uuid1()->getHex());
                $data['user_uuid'] = $user->admin_user_uuid;
                $this->validator->validate($data['data']);
                $article->exchangeArray($data['data']);
                if ($this->articleRepo->createArticle($article)) {
                    return $this->response->withStatus(302)->withHeader(
                        'Location',
                        $this->router->generateUri('admin.articles', ['action' => 'index'])
                    );
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

    public function doCreate()
    {


    }
}