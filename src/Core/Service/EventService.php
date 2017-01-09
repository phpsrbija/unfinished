<?php
namespace Core\Service;

use Core\Mapper\ArticleMapper;
use Core\Mapper\ArticleEventsMapper;
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

    public function __construct(ArticleMapper $articleMapper, ArticleEventsMapper $articleEventsMapper,
                                ArticleFilter $articleFilter, EventFilter $eventFilter)
    {
        $this->articleMapper       = $articleMapper;
        $this->articleEventsMapper = $articleEventsMapper;
        $this->articleFilter       = $articleFilter;
        $this->eventFilter         = $eventFilter;
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
        return $this->articleEventsMapper->get($articleId);
    }

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

        if($id){
            $old = $this->articleEventsMapper->get($id);
            $this->articleMapper->update($article, ['article_uuid' => $old->article_uuid]);
            $this->articleEventsMapper->update($event, ['article_uuid' => $old->article_uuid]);
        }
        else{
            $article['type']         = ArticleType::EVENT;
            $article['article_id']   = Uuid::uuid1()->toString();
            $article['article_uuid'] = (new MysqlUuid($article['article_id']))->toFormat(new Binary);
            $event['article_uuid']   = $article['article_uuid'];

            $this->articleMapper->insert($article);
            $this->articleEventsMapper->insert($event);
        }
    }

    public function deleteArticle($id)
    {
        $event = $this->articleEventsMapper->get($id);

        if(!$event){
            throw new \Exception('Article not found!');
        }

        $this->articleEventsMapper->delete(['article_uuid' => $event->article_uuid]);
        $this->articleMapper->delete(['article_uuid' => $event->article_uuid]);
    }

}
