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
     * @param Template $template
     * @param ArticleRepositoryInterface $articleRepo
     * @param Validator $validator
     * @param SessionManager $session
     * @param Router $router
     */
    public function __construct(
        Template $template,
        ArticleRepositoryInterface $articleRepo,
        Validator $validator,
        SessionManager $session,
        Router $router
    )
    {
        $this->template    = $template;
        $this->articleRepo = $articleRepo;
        $this->validator   = $validator;
        $this->session     = $session;
        $this->router      = $router;
    }

    public function index() : HtmlResponse
    {
        $articleCollection = $this->articleRepo->fetchAllArticles();

        $data = [
            'message'           => 'Article list',
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
            'data'    => $this->request->getParsedBody()
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
        try{
            $this->articleRepo->createArticle($this->request, $this->session->getStorage()->user->admin_user_uuid);
        }
        catch(\Exception $e){
            echo $e->getMessage();
            exit;

            //return $this->response->withStatus(302)->withHeader(
            //    'Location',
            //    $this->router->generateUri(
            //        'admin.articles.action',
            //        ['action' => 'create']
            //    )
            //);
        }

        return $this->response->withStatus(302)->withHeader(
            'Location',
            $this->router->generateUri('admin.articles')
        );
    }

    /**
     * Update article form.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update() : \Psr\Http\Message\ResponseInterface
    {
        $articleData = $this->articleRepo->fetchSingleArticle($this->request->getAttribute('id'));

        $data = [
            'message' => 'Update article',
            'data'    => $articleData
        ];

        return new HtmlResponse($this->template->render('admin::article/update', $data));
    }

    /**
     * Update article action.
     * Takes care of article update process.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function doupdate() : \Psr\Http\Message\ResponseInterface
    {
        try{
            $this->articleRepo->updateArticle($this->request, $this->session->getStorage()->user->admin_user_uuid);
            // @TODO ? handle (validation) errors
        }
        catch(\Exception $e){
            return $this->response->withStatus(302)->withHeader(
                'Location',
                $this->router->generateUri(
                    'admin.articles.action',
                    ['action' => 'update']
                )
            );
        }

        return $this->response->withStatus(302)->withHeader(
            'Location',
            $this->router->generateUri('admin.articles')
        );
    }

    public function delete() : \Psr\Http\Message\ResponseInterface
    {
        try{
            $this->articleRepo->deleteArticle($this->request->getAttribute('id'));
        }
        catch(\Exception $e){
            var_dump($e->getMessage());
            die();
        }

        return $this->response->withStatus(302)->withHeader(
            'Location',
            $this->router->generateUri(
                'admin.articles',
                ['action' => 'index']
            )
        );
    }
}
