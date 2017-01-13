<?php
declare(strict_types = 1);
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
use UploadHelper\Upload;
use Zend\Paginator\Paginator;

class PostService extends ArticleService
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

    /**
     * @var TagsMapper
     */
    private $tagsMapper;

    /**
     * @var Upload
     */
    private $upload;

    /**
     * PostService constructor.
     *
     * @param ArticleMapper $articleMapper
     * @param ArticlePostsMapper $articlePostsMapper
     * @param ArticleFilter $articleFilter
     * @param PostFilter $postFilter
     * @param ArticleTagsMapper $articleTagsMapper
     * @param TagsMapper $tagsMapper
     * @param Upload $upload
     */
    public function __construct(
        ArticleMapper $articleMapper,
        ArticlePostsMapper $articlePostsMapper,
        ArticleFilter $articleFilter,
        PostFilter $postFilter,
        ArticleTagsMapper $articleTagsMapper,
        TagsMapper $tagsMapper,
        Upload $upload
    ) {
        parent::__construct($articleMapper, $articleFilter);

        $this->articleMapper      = $articleMapper;
        $this->articlePostsMapper = $articlePostsMapper;
        $this->articleFilter      = $articleFilter;
        $this->postFilter         = $postFilter;
        $this->articleTagsMapper  = $articleTagsMapper;
        $this->tagsMapper         = $tagsMapper;
        $this->upload             = $upload;
    }

    public function fetchAllArticles($page, $limit) : Paginator
    {
        $select = $this->articlePostsMapper->getPaginationSelect();

        return $this->getPagination($select, $page, $limit);
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

        if (!$articleFilter->isValid() || !$postFilter->isValid()) {
            throw new FilterException($articleFilter->getMessages() + $postFilter->getMessages());
        }

        $article                    = $articleFilter->getValues();
        $post                       = $postFilter->getValues();
        $article['admin_user_uuid'] = $user->admin_user_uuid;

        if ($data['featured_img']['name']) {
            $image = $this->upload->filterImage($data, 'featured_img');
            $name  = $this->upload->uploadFile($image, 'featured_img');
            $path  = $this->upload->getWebPath($name);

            $post['featured_img'] = $path;
        } else {
            unset($data['featured_img']);
        }

        if ($data['main_img']['name']) {
            $image = $this->upload->filterImage($data, 'main_img');
            $name  = $this->upload->uploadFile($image, 'main_img');
            $path  = $this->upload->getWebPath($name);

            $post['main_img'] = $path;
        } else {
            unset($data['main_img']);
        }

        if ($id) {
            $oldPost = $this->articlePostsMapper->get($id);
            $this->articleMapper->update($article, ['article_uuid' => $oldPost->article_uuid]);
            $this->articlePostsMapper->update($post, ['article_uuid' => $oldPost->article_uuid]);
            $this->articleTagsMapper->delete(['article_uuid' => $oldPost->article_uuid]);
            $article['article_uuid'] = $oldPost->article_uuid;
        } else {
            $article['type']         = ArticleType::POST;
            $article['article_id']   = Uuid::uuid1()->toString();
            $article['article_uuid'] = (new MysqlUuid($article['article_id']))->toFormat(new Binary);
            $post['article_uuid']    = $article['article_uuid'];

            $this->articleMapper->insert($article);
            $this->articlePostsMapper->insert($post);
        }

        if(isset($data['tags']) && $data['tags']){
            $tags = $this->tagsMapper->select(['tag_id' => $data['tags']]);
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
        $this->delete($post->article_uuid);
    }

}
