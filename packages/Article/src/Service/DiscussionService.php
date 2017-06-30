<?php

declare(strict_types=1);

namespace Article\Service;

use Admin\Mapper\AdminUsersMapper;
use Article\Entity\ArticleType;
use Article\Filter\ArticleFilter;
use Article\Filter\DiscussionFilter;
use Article\Mapper\ArticleDiscussionsMapper;
use Article\Mapper\ArticleMapper;
use Category\Mapper\CategoryMapper;
use MysqlUuid\Formats\Binary;
use MysqlUuid\Uuid as MysqlUuid;
use Ramsey\Uuid\Uuid;
use Std\FilterException;

class DiscussionService extends ArticleService
{
    private $articleMapper;
    private $articleDiscussionsMapper;
    private $articleFilter;
    private $discussionFilter;
    private $categoryMapper;
    private $adminUsersMapper;

    public function __construct(
        ArticleMapper $articleMapper,
        ArticleDiscussionsMapper $articleDiscussionsMapper,
        ArticleFilter $articleFilter,
        DiscussionFilter $discussionFilter,
        CategoryMapper $categoryMapper,
        AdminUsersMapper $adminUsersMapper
    ) {
        parent::__construct($articleMapper, $articleFilter);

        $this->articleMapper = $articleMapper;
        $this->articleDiscussionsMapper = $articleDiscussionsMapper;
        $this->articleFilter = $articleFilter;
        $this->discussionFilter = $discussionFilter;
        $this->categoryMapper = $categoryMapper;
        $this->adminUsersMapper = $adminUsersMapper;
    }

    public function fetchAllArticles($page, $limit)
    {
        $select = $this->articleDiscussionsMapper->getPaginationSelect();

        return $this->getPagination($select, $page, $limit);
    }

    public function fetchSingleArticle($articleId)
    {
        return $this->articleDiscussionsMapper->get($articleId);
    }

    public function createArticle($user, $data)
    {
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $discussionFilter = $this->discussionFilter->getInputFilter()->setData($data);

        if (!$articleFilter->isValid() || !$discussionFilter->isValid()) {
            throw new FilterException($articleFilter->getMessages() + $discussionFilter->getMessages());
        }

        $id = Uuid::uuid1()->toString();
        $uuId = (new MysqlUuid($id))->toFormat(new Binary());

        $article = $articleFilter->getValues();
        $article += [
            'admin_user_uuid' => $this->adminUsersMapper->getUuid($article['admin_user_id']),
            'type'            => ArticleType::DISCUSSION,
            'article_id'      => $id,
            'article_uuid'    => $uuId,
        ];

        $article['category_uuid'] = $this->categoryMapper->get($article['category_id'])->category_uuid;
        unset($article['category_id'], $article['admin_user_id']);

        $discussion = $discussionFilter->getValues() + ['article_uuid' => $uuId];

        $this->articleMapper->insert($article);
        $this->articleDiscussionsMapper->insert($discussion);
    }

    public function updateArticle($data, $id)
    {
        $article = $this->articleDiscussionsMapper->get($id);
        $articleFilter = $this->articleFilter->getInputFilter()->setData($data);
        $discussionFilter = $this->discussionFilter->getInputFilter()->setData($data);

        if (!$articleFilter->isValid() || !$discussionFilter->isValid()) {
            throw new FilterException($articleFilter->getMessages() + $discussionFilter->getMessages());
        }

        $article = $articleFilter->getValues() + ['article_uuid' => $article->article_uuid];
        $discussion = $discussionFilter->getValues();

        $article['admin_user_uuid'] = $this->adminUsersMapper->getUuid($article['admin_user_id']);
        $article['category_uuid'] = $this->categoryMapper->get($article['category_id'])->category_uuid;
        unset($article['category_id'], $article['admin_user_id']);

        $this->articleMapper->update($article, ['article_uuid' => $article['article_uuid']]);
        $this->articleDiscussionsMapper->update($discussion, ['article_uuid' => $article['article_uuid']]);
    }

    public function deleteArticle($id)
    {
        $discussion = $this->articleDiscussionsMapper->get($id);

        if (!$discussion) {
            throw new \Exception('Article not found!');
        }

        $this->articleDiscussionsMapper->delete(['article_uuid' => $discussion->article_uuid]);
        $this->delete($discussion->article_uuid);
    }
}
