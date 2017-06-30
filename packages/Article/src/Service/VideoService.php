<?php

declare(strict_types=1);

namespace Article\Service;

use Admin\Mapper\AdminUsersMapper;
use Article\Entity\ArticleType;
use Article\Filter\ArticleFilter;
use Article\Filter\VideoFilter;
use Article\Mapper\ArticleMapper;
use Article\Mapper\ArticleVideosMapper;
use Category\Mapper\CategoryMapper;
use MysqlUuid\Formats\Binary;
use MysqlUuid\Uuid as MysqlUuid;
use Ramsey\Uuid\Uuid;
use Std\FilterException;
use UploadHelper\Upload;

class VideoService extends ArticleService
{
    /**
     * @var ArticleMapper
     */
    private $articleMapper;

    /**
     * @var ArticleVideosMapper
     */
    private $articleVideosMapper;

    /**
     * @var ArticleFilter
     */
    private $articleFilter;

    /**
     * @var VideoFilter
     */
    private $videosFilter;

    /**
     * @var CategoryMapper
     */
    private $categoryMapper;

    /**
     * @var Upload
     */
    private $upload;

    /**
     * @var AdminUsersMapper
     */
    private $adminUsersMapper;

    /**
     * VideosService constructor.
     *
     * @param ArticleMapper       $articleMapper
     * @param ArticleVideosMapper $articleVideosMapper
     * @param ArticleFilter       $articleFilter
     * @param VideoFilter         $videosFilter
     * @param CategoryMapper      $categoryMapper
     * @param Upload              $upload
     * @param AdminUsersMapper    $adminUsersMapper
     */
    public function __construct(
        ArticleMapper $articleMapper,
        ArticleVideosMapper $articleVideosMapper,
        ArticleFilter $articleFilter,
        VideoFilter $videosFilter,
        CategoryMapper $categoryMapper,
        Upload $upload,
        AdminUsersMapper $adminUsersMapper
    ) {
        parent::__construct($articleMapper, $articleFilter);

        $this->articleMapper = $articleMapper;
        $this->articleVideosMapper = $articleVideosMapper;
        $this->articleFilter = $articleFilter;
        $this->videosFilter = $videosFilter;
        $this->categoryMapper = $categoryMapper;
        $this->upload = $upload;
        $this->adminUsersMapper = $adminUsersMapper;
    }

    public function fetchAllArticles($page, $limit)
    {
        $select = $this->articleVideosMapper->getPaginationSelect();

        return $this->getPagination($select, $page, $limit);
    }

    public function fetchWebArticles($page = 1, $limit = 10)
    {
        $select = $this->articleVideosMapper->getPaginationSelect(true);

        return $this->getPagination($select, $page, $limit);
    }

    public function fetchLatest($limit)
    {
        return $this->articleVideosMapper->getLatest($limit);
    }

    public function fetchVideoBySlug($slug)
    {
        return $this->articleVideosMapper->getBySlug($slug);
    }

    public function fetchSingleArticle($articleId)
    {
        return $this->articleVideosMapper->get($articleId);
    }

    public function createArticle($user, $data)
    {
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $videosFilter = $this->videosFilter->getInputFilter()->setData($data);

        if (!$articleFilter->isValid() || !$videosFilter->isValid()) {
            throw new FilterException($articleFilter->getMessages() + $videosFilter->getMessages());
        }

        $id = Uuid::uuid1()->toString();
        $uuId = (new MysqlUuid($id))->toFormat(new Binary());

        $article = $articleFilter->getValues();
        $article += [
            'admin_user_uuid' => $this->adminUsersMapper->getUuid($article['admin_user_id']),
            'type'            => ArticleType::VIDEO,
            'article_id'      => $id,
            'article_uuid'    => $uuId,
        ];

        $article['category_uuid'] = $this->categoryMapper->get($article['category_id'])->category_uuid;
        unset($article['category_id'], $article['admin_user_id']);

        $videos = $videosFilter->getValues() + [
                'featured_img' => $this->upload->uploadImage($data, 'featured_img'),
                'main_img'     => $this->upload->uploadImage($data, 'main_img'),
                'article_uuid' => $uuId,
            ];

        $this->articleMapper->insert($article);
        $this->articleVideosMapper->insert($videos);
    }

    public function updateArticle($data, $id)
    {
        $oldArticle = $this->articleVideosMapper->get($id);
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $videosFilter = $this->videosFilter->getInputFilter()->setData($data);

        if (!$articleFilter->isValid() || !$videosFilter->isValid()) {
            throw new FilterException($articleFilter->getMessages() + $videosFilter->getMessages());
        }

        $article = $articleFilter->getValues() + ['article_uuid' => $oldArticle->article_uuid];
        $article['category_uuid'] = $this->categoryMapper->get($article['category_id'])->category_uuid;
        $article['admin_user_uuid'] = $this->adminUsersMapper->getUuid($article['admin_user_id']);
        unset($article['category_id']);
        unset($article['admin_user_id']);

        $videos = $videosFilter->getValues() + [
                'featured_img' => $this->upload->uploadImage($data, 'featured_img'),
                'main_img'     => $this->upload->uploadImage($data, 'main_img'),
            ];

        // We don't want to force user to re-upload image on edit
        if (!$videos['featured_img']) {
            unset($videos['featured_img']);
        } else {
            $this->upload->deleteFile($oldArticle->featured_img);
        }

        if (!$videos['main_img']) {
            unset($videos['main_img']);
        } else {
            $this->upload->deleteFile($oldArticle->main_img);
        }

        $this->articleMapper->update($article, ['article_uuid' => $article['article_uuid']]);
        $this->articleVideosMapper->update($videos, ['article_uuid' => $article['article_uuid']]);
    }

    public function deleteArticle($id)
    {
        $video = $this->articleVideosMapper->get($id);

        if (!$video) {
            throw new \Exception('Article not found!');
        }

        $this->upload->deleteFile($video->main_img);
        $this->upload->deleteFile($video->featured_img);
        $this->articleVideosMapper->delete(['article_uuid' => $video->article_uuid]);
        $this->delete($video->article_uuid);
    }
}
