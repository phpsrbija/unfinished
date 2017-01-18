<?php
declare(strict_types = 1);
namespace Core\Service;

use Core\Mapper\ArticleMapper;
use Core\Mapper\ArticleTagsMapper;
use Core\Mapper\ArticleVideosMapper;
use Core\Mapper\TagsMapper;
use Core\Entity\ArticleType;
use Core\Filter\ArticleFilter;
use Core\Exception\FilterException;
use Core\Filter\VideoFilter;
use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
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
     * VideosService constructor.
     *
     * @param ArticleMapper $articleMapper
     * @param ArticleVideosMapper $articleVideosMapper
     * @param ArticleFilter $articleFilter
     * @param VideoFilter $videosFilter
     * @param ArticleTagsMapper $articleTagsMapper
     * @param TagsMapper $tagsMapper
     * @param Upload $upload
     */
    public function __construct(
        ArticleMapper $articleMapper,
        ArticleVideosMapper $articleVideosMapper,
        ArticleFilter $articleFilter,
        VideoFilter $videosFilter,
        ArticleTagsMapper $articleTagsMapper,
        TagsMapper $tagsMapper,
        Upload $upload
    )
    {
        parent::__construct($articleMapper, $articleFilter);

        $this->articleMapper       = $articleMapper;
        $this->articleVideosMapper = $articleVideosMapper;
        $this->articleFilter       = $articleFilter;
        $this->videosFilter        = $videosFilter;
        $this->articleTagsMapper   = $articleTagsMapper;
        $this->tagsMapper          = $tagsMapper;
        $this->upload              = $upload;
    }

    public function fetchAllArticles($page, $limit)
    {
        $select = $this->articleVideosMapper->getPaginationSelect();

        return $this->getPagination($select, $page, $limit);
    }

    public function fetchSingleArticle($articleId)
    {
        $article = $this->articleVideosMapper->get($articleId);

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
        throw new \Exception('Depracticated');
    }

    public function createArticle($user, $data)
    {
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $videosFilter  = $this->videosFilter->getInputFilter()->setData($data);

        if(!$articleFilter->isValid() || !$videosFilter->isValid()){
            throw new FilterException($articleFilter->getMessages() + $videosFilter->getMessages());
        }

        $id   = Uuid::uuid1()->toString();
        $uuId = (new MysqlUuid($id))->toFormat(new Binary);

        $article = $articleFilter->getValues() + [
                'admin_user_uuid' => $user->admin_user_uuid,
                'type'            => ArticleType::POST,
                'article_id'      => $id,
                'article_uuid'    => $uuId
            ];

        $videos = $videosFilter->getValues() + [
                'featured_img' => $this->upload->uploadImage($data, 'featured_img'),
                'main_img'     => $this->upload->uploadImage($data, 'main_img'),
                'article_uuid' => $uuId
            ];

        $this->articleMapper->insert($article);
        $this->articleVideosMapper->insert($videos);

        if(isset($data['tags']) && $data['tags']){
            $tags = $this->tagsMapper->select(['tag_id' => $data['tags']]);
            $this->articleMapper->insertTags($tags, $article['article_uuid']);
        }
    }

    public function updateArticle($data, $id)
    {
        $article       = $this->articleVideosMapper->get($id);
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $videosFilter  = $this->videosFilter->getInputFilter()->setData($data);

        if(!$articleFilter->isValid() || !$videosFilter->isValid()){
            throw new FilterException($articleFilter->getMessages() + $videosFilter->getMessages());
        }

        $article = $articleFilter->getValues() + ['article_uuid' => $article->article_uuid];
        $videos  = $videosFilter->getValues() + [
                'featured_img' => $this->upload->uploadImage($data, 'featured_img'),
                'main_img'     => $this->upload->uploadImage($data, 'main_img')
            ];

        // We dont want to force user to re-upload image on edit
        if(!$videos['featured_img']){
            unset($videos['featured_img']);
        }

        if(!$videos['main_img']){
            unset($videos['main_img']);
        }

        $this->articleMapper->update($article, ['article_uuid' => $article['article_uuid']]);
        $this->articleVideosMapper->update($videos, ['article_uuid' => $article['article_uuid']]);
        $this->articleTagsMapper->delete(['article_uuid' => $article['article_uuid']]);

        if(isset($data['tags']) && $data['tags']){
            $tags = $this->tagsMapper->select(['tag_id' => $data['tags']]);
            $this->articleMapper->insertTags($tags, $article['article_uuid']);
        }
    }

    public function deleteArticle($id)
    {
        $video = $this->articleVideosMapper->get($id);

        if(!$video){
            throw new \Exception('Article not found!');
        }

        $this->articleVideosMapper->delete(['article_uuid' => $video->article_uuid]);
        $this->delete($video->article_uuid);
    }

}
