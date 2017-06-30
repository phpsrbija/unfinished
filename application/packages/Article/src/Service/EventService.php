<?php
declare(strict_types = 1);
namespace Article\Service;

use UploadHelper\Upload;
use Article\Mapper\ArticleMapper;
use Article\Mapper\ArticleEventsMapper;
use Category\Mapper\CategoryMapper;
use Article\Entity\ArticleType;
use Article\Filter\ArticleFilter;
use Article\Filter\EventFilter;
use Std\FilterException;
use Admin\Mapper\AdminUsersMapper;
use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;

class EventService extends ArticleService
{
    private $articleMapper;
    private $articleEventsMapper;
    private $articleFilter;
    private $eventFilter;
    private $categoryMapper;
    private $upload;
    private $adminUsersMapper;

    public function __construct(
        ArticleMapper $articleMapper,
        ArticleEventsMapper $articleEventsMapper,
        ArticleFilter $articleFilter,
        EventFilter $eventFilter,
        CategoryMapper $categoryMapper,
        Upload $upload,
        AdminUsersMapper $adminUsersMapper
    ) {

        parent::__construct($articleMapper, $articleFilter);
        $this->articleMapper = $articleMapper;
        $this->articleEventsMapper = $articleEventsMapper;
        $this->articleFilter = $articleFilter;
        $this->eventFilter = $eventFilter;
        $this->categoryMapper = $categoryMapper;
        $this->upload = $upload;
        $this->adminUsersMapper = $adminUsersMapper;
    }

    public function fetchAllArticles($page, $limit)
    {
        $select = $this->articleEventsMapper->getPaginationSelect();

        return $this->getPagination($select, $page, $limit);
    }

    public function fetchFutureEvents()
    {
        return $this->articleEventsMapper->getFuture();
    }

    public function fetchPastEventsPagination($page = 1, $limit = 10)
    {
        $select = $this->articleEventsMapper->getPastSelect();

        return $this->getPagination($select, $page, $limit);
    }

    public function fetchEvents($page = 1, $limit = 10)
    {
        $status = 1;
        $select = $this->articleEventsMapper->getPaginationSelect($status);

        return $this->getPagination($select, $page, $limit);
    }

    public function fetchLatest($limit)
    {
        return $this->articleEventsMapper->getLatest($limit);
    }

    public function fetchSingleArticle($articleId)
    {
        return $this->articleEventsMapper->get($articleId);
    }

    public function fetchEventBySlug($slug)
    {
        return $this->articleEventsMapper->getBySlug($slug);
    }

    public function createArticle($user, $data)
    {
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $eventFilter = $this->eventFilter->getInputFilter()->setData($data);

        if (!$articleFilter->isValid() || !$eventFilter->isValid()) {
            throw new FilterException($articleFilter->getMessages() + $eventFilter->getMessages());
        }

        $id = Uuid::uuid1()->toString();
        $uuId = (new MysqlUuid($id))->toFormat(new Binary);

        $article = $articleFilter->getValues();
        $article += [
            'admin_user_uuid' => $this->adminUsersMapper->getUuid($article['admin_user_id']),
            'type' => ArticleType::EVENT,
            'article_id' => $id,
            'article_uuid' => $uuId
        ];
        unset($article['admin_user_id']);

        $article['category_uuid'] = $this->categoryMapper->get($article['category_id'])->category_uuid;
        unset($article['category_id']);

        $event = $eventFilter->getValues() + [
                'featured_img' => $this->upload->uploadImage($data, 'featured_img'),
                'main_img' => $this->upload->uploadImage($data, 'main_img'),
                'article_uuid' => $uuId
            ];

        $this->articleMapper->insert($article);
        $this->articleEventsMapper->insert($event);
    }

    public function updateArticle($data, $id)
    {
        $oldArticle = $this->articleEventsMapper->get($id);
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $eventFilter = $this->eventFilter->getInputFilter()->setData($data);

        if (!$articleFilter->isValid() || !$eventFilter->isValid()) {
            throw new FilterException($articleFilter->getMessages() + $eventFilter->getMessages());
        }

        $article = $articleFilter->getValues() + ['article_uuid' => $oldArticle->article_uuid];
        $event = $eventFilter->getValues() + [
                'featured_img' => $this->upload->uploadImage($data, 'featured_img'),
                'main_img' => $this->upload->uploadImage($data, 'main_img')
            ];

        $article['admin_user_uuid'] = $this->adminUsersMapper->getUuid($article['admin_user_id']);
        $article['category_uuid'] = $this->categoryMapper->get($article['category_id'])->category_uuid;
        unset($article['category_id'], $article['admin_user_id']);

        // We don't want to force user to re-upload image on edit
        if (!$event['featured_img']) {
            unset($event['featured_img']);
        } else {
            $this->upload->deleteFile($oldArticle->featured_img);
        }

        if (!$event['main_img']) {
            unset($event['main_img']);
        } else {
            $this->upload->deleteFile($oldArticle->main_img);
        }

        $this->articleMapper->update($article, ['article_uuid' => $article['article_uuid']]);
        $this->articleEventsMapper->update($event, ['article_uuid' => $article['article_uuid']]);
    }

    public function deleteArticle($id)
    {
        $event = $this->articleEventsMapper->get($id);

        if (!$event) {
            throw new \Exception('Article not found!');
        }

        $this->upload->deleteFile($event->main_img);
        $this->upload->deleteFile($event->featured_img);
        $this->articleEventsMapper->delete(['article_uuid' => $event->article_uuid]);
        $this->delete($event->article_uuid);
    }
}
