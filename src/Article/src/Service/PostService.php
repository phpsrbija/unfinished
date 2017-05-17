<?php

declare(strict_types=1);

namespace Article\Service;

use Article\Mapper\ArticleMapper;
use Article\Mapper\ArticlePostsMapper;
use Category\Mapper\CategoryMapper;
use Article\Entity\ArticleType;
use Article\Filter\ArticleFilter;
use Core\Exception\FilterException;
use Article\Filter\PostFilter;
use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
use UploadHelper\Upload;
use Zend\Paginator\Paginator;

class PostService extends ArticleService
{
    /** @var ArticleMapper */
    private $articleMapper;

    /** @var ArticlePostsMapper */
    private $articlePostsMapper;

    /** @var ArticleFilter */
    private $articleFilter;

    /** @var PostFilter */
    private $postFilter;

    /** @var CategoryMapper */
    private $categoryMapper;

    /** @var Upload */
    private $upload;

    /**
     * PostService constructor.
     *
     * @param ArticleMapper $articleMapper
     * @param ArticlePostsMapper $articlePostsMapper
     * @param ArticleFilter $articleFilter
     * @param PostFilter $postFilter
     * @param CategoryMapper $categoryMapper
     * @param Upload $upload
     */
    public function __construct(ArticleMapper $articleMapper, ArticlePostsMapper $articlePostsMapper, ArticleFilter $articleFilter,
                                PostFilter $postFilter, CategoryMapper $categoryMapper, Upload $upload)
    {
        parent::__construct($articleMapper, $articleFilter);

        $this->articleMapper      = $articleMapper;
        $this->articlePostsMapper = $articlePostsMapper;
        $this->articleFilter      = $articleFilter;
        $this->postFilter         = $postFilter;
        $this->categoryMapper     = $categoryMapper;
        $this->upload             = $upload;
    }

    public function fetchAllArticles($page, $limit): Paginator
    {
        $select = $this->articlePostsMapper->getPaginationSelect();

        return $this->getPagination($select, $page, $limit);
    }

    public function fetchSingleArticleBySlug($slug)
    {
        $article = $this->articlePostsMapper->getBySlug($slug);

        if($article) {
            $article['categories'] = $this->getCategoryIds($article->article_id);
        }

        return $article;
    }

    public function fetchSingleArticle($articleId)
    {
        $article = $this->articlePostsMapper->get($articleId);

        if($article) {
            $article['categories'] = $this->getCategoryIds($articleId);
        }

        return $article;
    }

    public function createArticle($user, $data)
    {
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $postFilter    = $this->postFilter->getInputFilter()->setData($data);

        if(!$articleFilter->isValid() || !$postFilter->isValid()) {
            throw new FilterException($articleFilter->getMessages() + $postFilter->getMessages());
        }

        $id   = Uuid::uuid1()->toString();
        $uuId = (new MysqlUuid($id))->toFormat(new Binary);

        $article = $articleFilter->getValues() + [
                'admin_user_uuid' => $user->admin_user_uuid,
                'type'            => ArticleType::POST,
                'article_id'      => $id,
                'article_uuid'    => $uuId
            ];

        $post = $postFilter->getValues() + [
                'featured_img' => $this->upload->uploadImage($data, 'featured_img'),
                'main_img'     => $this->upload->uploadImage($data, 'main_img'),
                'article_uuid' => $article['article_uuid']
            ];

        if($post['is_homepage']) {
            $this->articlePostsMapper->update(['is_homepage' => false]);
        }

        $this->articleMapper->insert($article);
        $this->articlePostsMapper->insert($post);

        if(isset($data['categories']) && $data['categories']) {
            $categories = $this->categoryMapper->select(['category_id' => $data['categories']]);
            $this->articleMapper->insertCategories($categories, $article['article_uuid']);
        }
    }

    public function updateArticle($data, $id)
    {
        $article       = $this->articlePostsMapper->get($id);
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $postFilter    = $this->postFilter->getInputFilter()->setData($data);

        if(!$articleFilter->isValid() || !$postFilter->isValid()) {
            throw new FilterException($articleFilter->getMessages() + $postFilter->getMessages());
        }

        $article = $articleFilter->getValues() + ['article_uuid' => $article->article_uuid];
        $post    = $postFilter->getValues() + [
                'featured_img' => $this->upload->uploadImage($data, 'featured_img'),
                'main_img'     => $this->upload->uploadImage($data, 'main_img')
            ];

        // We dont want to force user to re-upload image on edit
        if(!$post['featured_img']) {
            unset($post['featured_img']);
        }

        if(!$post['main_img']) {
            unset($post['main_img']);
        }

        if($post['is_homepage']) {
            $this->articlePostsMapper->update(['is_homepage' => false]);
        }

        $this->articleMapper->update($article, ['article_uuid' => $article['article_uuid']]);
        $this->articlePostsMapper->update($post, ['article_uuid' => $article['article_uuid']]);
        $this->articleMapper->deleteCategories($article['article_uuid']);

        if(isset($data['categories']) && $data['categories']) {
            $categories = $this->categoryMapper->select(['category_id' => $data['categories']]);
            $this->articleMapper->insertCategories($categories, $article['article_uuid']);
        }
    }

    public function deleteArticle($id)
    {
        $post = $this->articlePostsMapper->get($id);

        if(!$post) {
            throw new \Exception('Article not found!');
        }

        $this->articlePostsMapper->delete(['article_uuid' => $post->article_uuid]);
        $this->delete($post->article_uuid);
    }

    public function getForSelect()
    {
        return $this->articlePostsMapper->getAll();
    }

    public function getHomepage()
    {
        $article = $this->articlePostsMapper->getHomepage();

        return $article;
    }

    public function getCategories($articleId)
    {
        return $this->articleMapper->getCategories($articleId);
    }

    public function getLatestWeb($limit)
    {
        return $this->articlePostsMapper->getLatest($limit);
    }

}
