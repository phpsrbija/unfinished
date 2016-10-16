<?php
declare(strict_types = 1);

namespace Test\Admin\Model\Entity;

class ArticleEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testStandardGetters()
    {
        $article = new \Admin\Model\Entity\ArticleEntity();

        $articleData = array(
            'title' => 'test title',
            'lead' => 'test lead',
            'articleUuid' => '123-456-789',
            'slug' => 'article-slug',
            'body' => 'body content',
            'type' => 1,
            'status' => 1,
            'userId' => 1,
            'createdAt' => new \DateTime('now'),
            'publishedAt' => new \DateTime('now'),
        );

        $article->exchangeArray($articleData);
        static::assertSame($articleData['title'], $article->getTitle());
        static::assertSame($articleData['lead'], $article->getLead());
        static::assertSame($articleData['articleUuid'], $article->getArticleUuid());
        static::assertSame($articleData['slug'], $article->getSlug());
        static::assertSame($articleData['body'], $article->getBody());
        static::assertSame($articleData['type'], $article->getType());
        static::assertSame($articleData['status'], $article->getStatus());
        static::assertSame($articleData['createdAt'], $article->getCreatedAt());
        static::assertSame($articleData['publishedAt'], $article->getPublishedAt());
        static::assertSame($articleData['userId'], $article->getUserId());
        static::assertEquals($articleData, $article->getArrayCopy());
    }

}
