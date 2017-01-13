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
    ) {
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
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $videosFilter    = $this->videosFilter->getInputFilter()->setData($data);

        if (!$articleFilter->isValid() || !$videosFilter->isValid()) {
            throw new FilterException($articleFilter->getMessages() + $videosFilter->getMessages());
        }

        $article                    = $articleFilter->getValues();
        $videos                       = $videosFilter->getValues();
        $article['admin_user_uuid'] = $user->admin_user_uuid;

        if ($data['featured_img']['name']) {
            $image = $this->upload->filterImage($data, 'featured_img');
            $name  = $this->upload->uploadFile($image, 'featured_img');
            $path  = $this->upload->getWebPath($name);

            $videos['featured_img'] = $path;
        } else {
            unset($data['featured_img']);
        }

        if ($data['main_img']['name']) {
            $image = $this->upload->filterImage($data, 'main_img');
            $name  = $this->upload->uploadFile($image, 'main_img');
            $path  = $this->upload->getWebPath($name);

            $videos['main_img'] = $path;
        } else {
            unset($data['main_img']);
        }

        if ($id) {
            $oldVideos = $this->articleVideosMapper->get($id);
            $this->articleMapper->update($article, ['article_uuid' => $oldVideos->article_uuid]);
            $this->articleVideosMapper->update($videos, ['article_uuid' => $oldVideos->article_uuid]);
            $this->articleTagsMapper->delete(['article_uuid' => $oldVideos->article_uuid]);
            $article['article_uuid'] = $oldVideos->article_uuid;
        } else {
            $article['type']         = ArticleType::POST;
            $article['article_id']   = Uuid::uuid1()->toString();
            $article['article_uuid'] = (new MysqlUuid($article['article_id']))->toFormat(new Binary);
            $videos['article_uuid']    = $article['article_uuid'];

            $this->articleMapper->insert($article);
            $this->articleVideosMapper->insert($videos);
        }

        if(isset($data['tags']) && $data['tags']){
            $tags = $this->tagsMapper->select(['tag_id' => $data['tags']]);
            $this->articleMapper->insertTags($tags, $article['article_uuid']);
        }
    }

    public function deleteArticle($id)
    {
        $videos = $this->articleVideosMapper->get($id);

        if(!$videos){
            throw new \Exception('Article not found!');
        }

        $this->articleTagsMapper->delete(['article_uuid' => $videos->article_uuid]);
        $this->delete($videos->article_uuid);
    }

}
