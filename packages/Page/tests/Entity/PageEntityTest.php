<?php

declare(strict_types=1);

namespace Page\Test\Entity;

class PageEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testStandardGettersAndSetters()
    {
        $page = new \Page\Entity\Page();

        $date = date('d.m.Y', time());
        $dateFormatted = date('Y/m/d', time());

        $page->setBody('test');
        $page->setCreatedAt($date);
        $page->setDescription('test');
        $page->setHasLayout(1);
        $page->setIsActive(1);
        $page->setIsHomepage(1);
        $page->setIsWysiwygEditor(1);
        $page->setMainImg('test');
        $page->setPageId(1);
        $page->setPageUuid('test');
        $page->setSlug('test');
        $page->setTitle('test');

        static::assertSame('test', $page->getBody());
        static::assertSame($date, $page->getCreatedAt());
        static::assertSame($dateFormatted, $page->getCreatedAt('Y/m/d'));
        static::assertSame('test', $page->getDescription());
        static::assertSame('te', $page->getDescription(2));
        static::assertSame(1, $page->getHasLayout());
        static::assertSame(1, $page->getIsActive());
        static::assertSame(1, $page->getIsHomepage());
        static::assertSame(1, $page->getIsWysiwygEditor());
        static::assertSame(1, $page->getPageId());
        static::assertSame('test', $page->getMainImg());
        static::assertSame('test', $page->getPageUuid());
        static::assertSame('test', $page->getSlug());
        static::assertSame('test', $page->getTitle());
        static::assertSame(
            [
            'page_uuid'         => 'test',
            'page_id'           => '1',
            'title'             => 'test',
            'body'              => 'test',
            'description'       => 'test',
            'main_img'          => 'test',
            'has_layout'        => true,
            'is_homepage'       => true,
            'is_active'         => true,
            'is_wysiwyg_editor' => true,
            'created_at'        => $date,
            'slug'              => 'test',
            ], $page->getArrayCopy()
        );
    }
}
