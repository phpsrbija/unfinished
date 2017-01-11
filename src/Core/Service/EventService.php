<?php

namespace Core\Service;

use UploadHelper\Upload;
use Core\Mapper\ArticleMapper;
use Core\Mapper\ArticleEventsMapper;
use Core\Mapper\TagsMapper;
use Core\Entity\ArticleType;
use Core\Filter\ArticleFilter;
use Core\Exception\FilterException;
use Core\Filter\EventFilter;
use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Db\ResultSet\HydratingResultSet as ResultSet;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

class EventService implements ArticleServiceInterface
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
        $this->articleMapper       = $articleMapper;
        $this->articleEventsMapper = $articleEventsMapper;
        $this->articleFilter       = $articleFilter;
        $this->eventFilter         = $eventFilter;
        $this->tagsMapper          = $tagsMapper;
        $this->upload              = $upload;
    }

    public function fetchAllArticles($page, $limit)
    {
        $select           = $this->articleEventsMapper->getPaginationSelect();
        $paginatorAdapter = new DbSelect($select, $this->articleMapper->getAdapter());
        $paginator        = new Paginator($paginatorAdapter);

        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($limit);

        return $paginator;
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

    /**
     * 1. Validate/filter data
     * 2. Upload image and add it to the array for saving
     * 3. Save data (add/edit)
     * 4. Inser new tags tags
     */
    public function saveArticle($user, $data, $id = null)
    {
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $eventFilter   = $this->eventFilter->getInputFilter()->setData($data);

        if(!$articleFilter->isValid() || !$eventFilter->isValid()){
            throw new FilterException($articleFilter->getMessages() + $eventFilter->getMessages());
        }

        $article                    = $articleFilter->getValues();
        $event                      = $eventFilter->getValues();
        $article['admin_user_uuid'] = $user->admin_user_uuid;

        if($data['featured_img']['name']){
            $image = $this->upload->filterImage($data, 'featured_img');
            $name  = $this->upload->uploadFile($image, 'featured_img');
            $path  = $this->upload->getWebPath($name);

            $event['featured_img'] = $path;
        }
        else{
            unset($data['featured_img']);
        }

        if($data['main_img']['name']){
            $image = $this->upload->filterImage($data, 'main_img');
            $name  = $this->upload->uploadFile($image, 'main_img');
            $path  = $this->upload->getWebPath($name);

            $event['main_img'] = $path;
        }
        else{
            unset($data['main_img']);
        }

        if($id){
            $old       = $this->articleEventsMapper->get($id);
            $articleId = $old->article_uuid;
            $this->articleMapper->update($article, ['article_uuid' => $old->article_uuid]);
            $this->articleEventsMapper->update($event, ['article_uuid' => $old->article_uuid]);
            $this->articleMapper->deleteTags($old->article_uuid);
        }
        else{
            $article['type']         = ArticleType::EVENT;
            $article['article_id']   = Uuid::uuid1()->toString();
            $article['article_uuid'] = (new MysqlUuid($article['article_id']))->toFormat(new Binary);
            $event['article_uuid']   = $article['article_uuid'];

            $this->articleMapper->insert($article);
            $this->articleEventsMapper->insert($event);
            $articleId = $event['article_uuid'];
        }

        if(isset($data['tags'])){
            $tags = $this->tagsMapper->select(['tag_id' => $data['tags']]);
            $this->articleMapper->insertTags($tags, $articleId);
        }
    }

    public function deleteArticle($id)
    {
        $event = $this->articleEventsMapper->get($id);

        if(!$event){
            throw new \Exception('Article not found!');
        }

        $this->articleEventsMapper->delete(['article_uuid' => $event->article_uuid]);
        $this->articleMapper->deleteTags($event->article_uuid);
        $this->articleMapper->delete(['article_uuid' => $event->article_uuid]);
    }

}
