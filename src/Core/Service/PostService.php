<?php
namespace Core\Service;

use Core\Mapper\ArticleMapper;
use Core\Mapper\ArticlePostsMapper;
use Core\Entity\ArticleType;
use Core\Filter\ArticleFilter;
use Core\Exception\FilterException;
use Core\Filter\PostFilter;
use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Db\ResultSet\HydratingResultSet as ResultSet;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

class PostService implements ArticleServiceInterface
{
    private $articleMapper;
    private $articlePostsMapper;
    private $articleFilter;
    private $postFilter;

    public function __construct(ArticleMapper $articleMapper, ArticlePostsMapper $articlePostsMapper, ArticleFilter $articleFilter, PostFilter $postFilter)
    {
        $this->articleMapper      = $articleMapper;
        $this->articlePostsMapper = $articlePostsMapper;
        $this->articleFilter      = $articleFilter;
        $this->postFilter         = $postFilter;
    }

    public function fetchAllArticles($page, $limit)
    {
        $select           = $this->articlePostsMapper->getPaginationSelect();
        $paginatorAdapter = new DbSelect($select, $this->articleMapper->getAdapter());
        $paginator        = new Paginator($paginatorAdapter);

        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($limit);

        return $paginator;
    }

    public function fetchSingleArticle($articleId)
    {
        return $this->articlePostsMapper->get($articleId);
    }

    public function saveArticle($user, $data, $id = null)
    {
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $postFilter    = $this->postFilter->getInputFilter()->setData($data);

        if(!$articleFilter->isValid() || !$postFilter->isValid()){
            throw new FilterException($articleFilter->getMessages() + $postFilter->getMessages());
        }

        $article                    = $articleFilter->getValues();
        $post                       = $postFilter->getValues();
        $article['admin_user_uuid'] = $user->admin_user_uuid;

        if($id){
            $oldPost = $this->articlePostsMapper->get($id);
            $this->articleMapper->update($article, ['article_uuid' => $oldPost->article_uuid]);
            $this->articlePostsMapper->update($post, ['article_uuid' => $oldPost->article_uuid]);
        }
        else{
            $article['type']         = ArticleType::POST;
            $article['article_id']   = Uuid::uuid1()->toString();
            $article['article_uuid'] = (new MysqlUuid($article['article_id']))->toFormat(new Binary);
            $post['article_uuid']    = $article['article_uuid'];

            $this->articleMapper->insert($article);
            $this->articlePostsMapper->insert($post);
        }
    }

    public function deleteArticle($id)
    {
        $post = $this->articlePostsMapper->get($id);

        if(!$post){
            throw new \Exception('Article not found!');
        }

        $this->articlePostsMapper->delete(['article_uuid' => $post->article_uuid]);
        $this->articleMapper->delete(['article_uuid' => $post->article_uuid]);
    }

}
