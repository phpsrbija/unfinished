<?php

namespace Core\Service\Article;

use UploadHelper\Upload;
use Core\Mapper\ArticleMapper;
use Core\Mapper\ArticleEventsMapper;
use Core\Mapper\TagsMapper;
use Core\Entity\ArticleType;
use Core\Filter\ArticleFilter;
use Core\Filter\EventFilter;
use Core\Exception\FilterException;
use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;

class EventService extends ArticleService
{
    private $articleMapper;
    private $articleEventsMapper;
    private $articleFilter;
    private $eventFilter;
    private $tagsMapper;
    private $upload;

    public function __construct(ArticleMapper $articleMapper, ArticleEventsMapper $articleEventsMapper,
                                ArticleFilter $articleFilter, EventFilter $eventFilter, TagsMapper $tagsMapper, Upload $upload)
    {
        parent::__construct($articleMapper, $articleFilter);

        $this->articleMapper       = $articleMapper;
        $this->articleEventsMapper = $articleEventsMapper;
        $this->articleFilter       = $articleFilter;
        $this->eventFilter         = $eventFilter;
        $this->tagsMapper          = $tagsMapper;
        $this->upload              = $upload;
    }

    public function fetchAllArticles($page, $limit)
    {
        $select = $this->articleEventsMapper->getPaginationSelect();

        return $this->getPagination($select, $page, $limit);
    }

    public function fetchSingleArticle($articleId)
    {
        $event = $this->articleEventsMapper->get($articleId);

        if($event){
            $event['tags'] = [];
            foreach($this->articleMapper->getTages($articleId) as $tag){
                $event['tags'][] = $tag->tag_id;
            }
        }

        return $event;
    }

    public function saveArticle($user, $data, $id = null)
    {
        throw new \Exception('Depracticated!');
    }

    public function createArticle($user, $data)
    {
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $eventFilter   = $this->eventFilter->getInputFilter()->setData($data);

        if(!$articleFilter->isValid() || !$eventFilter->isValid()){
            throw new FilterException($articleFilter->getMessages() + $eventFilter->getMessages());
        }

        $id   = Uuid::uuid1()->toString();
        $uuId = (new MysqlUuid($id))->toFormat(new Binary);

        $article = $articleFilter->getValues() + [
                'admin_user_uuid' => $user->admin_user_uuid,
                'type'            => ArticleType::EVENT,
                'article_id'      => $id,
                'article_uuid'    => $uuId
            ];

        $event = $eventFilter->getValues() + [
                'featured_img' => $this->upload->uploadImage($data, 'featured_img'),
                'main_img'     => $this->upload->uploadImage($data, 'main_img'),
                'article_uuid' => $uuId
            ];

        $this->articleMapper->insert($article);
        $this->articleEventsMapper->insert($event);

        if(isset($data['tags'])){
            $tags = $this->tagsMapper->select(['tag_id' => $data['tags']]);
            $this->articleMapper->insertTags($tags, $event['article_uuid']);
        }
    }

    public function updateArticle($data, $id)
    {
        $article       = $this->articleEventsMapper->get($id);
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $eventFilter   = $this->eventFilter->getInputFilter()->setData($data);

        if(!$articleFilter->isValid() || !$eventFilter->isValid()){
            throw new FilterException($articleFilter->getMessages() + $eventFilter->getMessages());
        }

        $article = $articleFilter->getValues() + ['article_uuid' => $article->article_uuid];
        $event   = $eventFilter->getValues() + [
                'featured_img' => $this->upload->uploadImage($data, 'featured_img'),
                'main_img'     => $this->upload->uploadImage($data, 'main_img')
            ];

        // We dont want to force user to re-upload image on edit
        if(!$event['featured_img']){
            unset($event['featured_img']);
        }

        if(!$event['main_img']){
            unset($event['main_img']);
        }

        $this->articleMapper->update($article, ['article_uuid' => $article['article_uuid']]);
        $this->articleEventsMapper->update($event, ['article_uuid' => $article['article_uuid']]);
        $this->articleMapper->deleteTags($article['article_uuid']);

        if(isset($data['tags'])){
            $tags = $this->tagsMapper->select(['tag_id' => $data['tags']]);
            $this->articleMapper->insertTags($tags, $article['article_uuid']);
        }
    }

    public function deleteArticle($id)
    {
        $event = $this->articleEventsMapper->get($id);

        if(!$event){
            throw new \Exception('Article not found!');
        }

        $this->articleEventsMapper->delete(['article_uuid' => $event->article_uuid]);
        $this->delete($event->article_uuid);
    }

}
