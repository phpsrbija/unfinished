<?php

declare(strict_types=1);

namespace Article\Service;

use Article\Mapper\ArticleMapper;
use Article\Mapper\ArticlePostsMapper;
use Category\Mapper\CategoryMapper;
use Article\Entity\ArticleType;
use Article\Filter\ArticleFilter;
use Core\Exception\FilterException;
use Core\Mapper\AdminUsersMapper;
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

    /** @var  AdminUsersMapper */
    private $adminUsersMapper;

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
                                PostFilter $postFilter, CategoryMapper $categoryMapper, Upload $upload, AdminUsersMapper $adminUsersMapper)
    {
        parent::__construct($articleMapper, $articleFilter);

        $this->articleMapper      = $articleMapper;
        $this->articlePostsMapper = $articlePostsMapper;
        $this->articleFilter      = $articleFilter;
        $this->postFilter         = $postFilter;
        $this->categoryMapper     = $categoryMapper;
        $this->upload             = $upload;
        $this->adminUsersMapper   = $adminUsersMapper;
    }

    public function fetchAllArticles($page, $limit): Paginator
    {
        $select = $this->articlePostsMapper->getPaginationSelect();

        return $this->getPagination($select, $page, $limit);
    }

    public function fetchSingleArticleBySlug($slug)
    {
        return $this->articlePostsMapper->getBySlug($slug);
    }

    public function fetchSingleArticle($articleId)
    {
        return $this->articlePostsMapper->get($articleId);
    }

    public function fetchNearestArticle($articlePublishedAt)
    {
        return [
            $this->articlePostsMapper->getNear($articlePublishedAt, 1),
            $this->articlePostsMapper->getNear($articlePublishedAt, -1),
        ];
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

        $article = $articleFilter->getValues();
        $article += [
            'admin_user_uuid' => $this->adminUsersMapper->getUuid($article['admin_user_id']),
            'type'            => ArticleType::POST,
            'article_id'      => $id,
            'article_uuid'    => $uuId
        ];

        $article['category_uuid'] = $this->categoryMapper->get($article['category_id'])->category_uuid;
        unset($article['category_id'], $article['admin_user_id']);

        $post = $postFilter->getValues() + [
                'featured_img' => $this->upload->uploadImage($data, 'featured_img'),
                'main_img'     => $this->upload->uploadImage($data, 'main_img'),
                'article_uuid' => $article['article_uuid']
            ];

        $this->articleMapper->insert($article);
        $this->articlePostsMapper->insert($post);
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

        $article['admin_user_uuid'] = $this->adminUsersMapper->getUuid($article['admin_user_id']);
        $article['category_uuid']   = $this->categoryMapper->get($article['category_id'])->category_uuid;
        unset($article['category_id'], $article['admin_user_id']);

        // We dont want to force user to re-upload image on edit
        if(!$post['featured_img']) {
            unset($post['featured_img']);
        }

        if(!$post['main_img']) {
            unset($post['main_img']);
        }

        $this->articleMapper->update($article, ['article_uuid' => $article['article_uuid']]);
        $this->articlePostsMapper->update($post, ['article_uuid' => $article['article_uuid']]);
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

    public function getCategories($articleId)
    {
        return $this->articleMapper->getCategories($articleId);
    }

    public function getLatestWeb($limit)
    {
        return $this->articlePostsMapper->getLatest($limit);
    }

}
