<?php
namespace Core\Service;

use Core\Mapper\ArticleMapper;
use Core\Mapper\ArticleTagsMapper;
use Core\Mapper\ArticlePostsMapper;
use Core\Mapper\TagsMapper;
use Core\Entity\ArticleType;
use Core\Filter\ArticleFilter;
use Core\Exception\FilterException;
use Core\Filter\PostFilter;
use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

class PostService implements ArticleServiceInterface
{
    /**
     * @var ArticleMapper
     */
    private $articleMapper;

    /**
     * @var ArticlePostsMapper
     */
    private $articlePostsMapper;

    /**
     * @var ArticleFilter
     */
    private $articleFilter;

    /**
     * @var PostFilter
     */
    private $postFilter;

    /**
     * @var ArticleTagsMapper
     */
    private $articleTagsMapper;

    private $tagsMapper;

    /**
     * PostService constructor.
     *
     * @param ArticleMapper $articleMapper
     * @param ArticlePostsMapper $articlePostsMapper
     * @param ArticleFilter $articleFilter
     * @param PostFilter $postFilter
     * @param ArticleTagsMapper $articleTagsMapper
     */
    public function __construct(ArticleMapper $articleMapper, ArticlePostsMapper $articlePostsMapper, ArticleFilter $articleFilter,
                                PostFilter $postFilter, ArticleTagsMapper $articleTagsMapper, TagsMapper $tagsMapper)
    {
        $this->articleMapper      = $articleMapper;
        $this->articlePostsMapper = $articlePostsMapper;
        $this->articleFilter      = $articleFilter;
        $this->postFilter         = $postFilter;
        $this->articleTagsMapper  = $articleTagsMapper;
        $this->tagsMapper         = $tagsMapper;
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
        $article = $this->articlePostsMapper->get($articleId);

        if($article){
            $article['tags'] = [];
            foreach($this->articleMapper->getTages($articleId) as $tag){
                $article['tags'][] = $tag->tag_id;
            }
        }

        return $article;
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
            $this->articleTagsMapper->delete(['article_uuid' => $oldPost->article_uuid]);
            $article['article_uuid'] = $oldPost->article_uuid;
        }
        else{
            $article['type']         = ArticleType::POST;
            $article['article_id']   = Uuid::uuid1()->toString();
            $article['article_uuid'] = (new MysqlUuid($article['article_id']))->toFormat(new Binary);
            $post['article_uuid']    = $article['article_uuid'];

            $this->articleMapper->insert($article);
            $this->articlePostsMapper->insert($post);
        }

        if(isset($data['tag_uuid']) && $data['tag_uuid']){
            $tags = $this->tagsMapper->select(['tag_id' => $data['tag_uuid']]);
            $this->articleMapper->insertTags($tags, $article['article_uuid']);
        }
    }

    public function deleteArticle($id)
    {
        $post = $this->articlePostsMapper->get($id);

        if(!$post){
            throw new \Exception('Article not found!');
        }

        $this->articleTagsMapper->delete(['article_uuid' => $post->article_uuid]);
        $this->articlePostsMapper->delete(['article_uuid' => $post->article_uuid]);
        $this->articleMapper->delete(['article_uuid' => $post->article_uuid]);
    }

}
