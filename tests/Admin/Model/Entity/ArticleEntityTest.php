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
            'article_uuid' => null,
            'slug' => 'article-slug',
            'body' => 'body content',
            'type' => 1,
            'status' => 1,
            'user_uuid' => 1,
            'created_at' => '8-8-2016 0000:00:00',
            'published_at' => '8-8-2016 0000:00:00',
        );

        $article->exchangeArray($articleData);
        static::assertSame($articleData['title'], $article->getTitle());
        static::assertSame($articleData['lead'], $article->getLead());
        static::assertSame($articleData['slug'], $article->getSlug());
        static::assertSame($articleData['body'], $article->getBody());
        static::assertSame($articleData['type'], $article->getType());
        static::assertSame($articleData['status'], $article->getStatus());
        static::assertSame($articleData['created_at'], $article->getCreated_at());
        static::assertSame($articleData['published_at'], $article->getPublished_at());
        static::assertSame($articleData['user_uuid'], $article->getUser_uuid());
        static::assertEquals($articleData, $article->getArrayCopy());
    }

}
