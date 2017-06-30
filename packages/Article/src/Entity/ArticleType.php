<?php

namespace Article\Entity;

class ArticleType
{
    const POST = 1;
    const VIDEO = 2;
    const EVENT = 3;
    const DISCUSSION = 4;

    public static function all()
    {
        return [
            self::POST       => 'Post',
            self::VIDEO      => 'Video',
            self::EVENT      => 'Event',
            self::DISCUSSION => 'Discussion',
        ];
    }
}
