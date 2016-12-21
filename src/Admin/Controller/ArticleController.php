<?php
declare(strict_types = 1);
namespace Admin\Controller;

use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;
use Admin\Model\Repository\ArticleRepositoryInterface;
use Admin\Validator\ValidatorInterface as Validator;
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
     * @var Router
     */
    private $router;

    /**
     * ArticleController constructor.
     *
     * @param Template                   $template
     * @param ArticleRepositoryInterface $articleRepo
     * @param Validator                  $validator
     * @param SessionManager             $session
     * @param Router                     $router
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

    /**
     * Create article form.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create() : \Psr\Http\Message\ResponseInterface
    {
        $data = [
            'message' => 'Create article',
            'errors' => false,
            'data' => $this->request->getParsedBody()
        ];

        return new HtmlResponse($this->template->render('admin::article/create', $data));
    }

    /**
     * Create article action.
     * Takes care of article creation process.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function docreate() : \Psr\Http\Message\ResponseInterface
    {
        try {
            if ($this->articleRepo->createArticle($this->request, $this->session->getStorage()->user->admin_user_uuid))
            {
                return $this->response->withStatus(302)->withHeader(
                    'Location',
                    $this->router->generateUri('admin.articles.action', ['action' => 'index'])
                );
            }
        // @TODO ? handle (validation) errors
        } catch (\Exception $e) {
            return $this->response->withStatus(302)->withHeader(
                'Location',
                $this->router->generateUri(
                    'admin.articles.action',
                    ['action' => 'create']
                )
            );
        }
    }
}
