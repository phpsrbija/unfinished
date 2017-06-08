<?php

use Phinx\Seed\AbstractSeed;

class Menu extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $menu  = $this->table('menu');

        // Insert Posts menu
        $id        = $faker->uuid;
        $mysqlUuid = (new MysqlUuid\Uuid($id))->toFormat(new MysqlUuid\Formats\Binary());
        $menu->insert([
            'menu_uuid'     => $mysqlUuid,
            'menu_id'       => $id,
            'title'         => 'Posts',
            'href'          => 'all/',
            'is_active'     => true,
            'is_in_header'  => true,
            'is_in_footer'  => true,
            'is_in_side'    => false,
            'order_no'      => 1,
            'article_uuid'  => null,
            'category_uuid' => null
        ])->save();

        // Insert videos category in Menu
        $id            = $faker->uuid;
        $mysqlUuid     = (new MysqlUuid\Uuid($id))->toFormat(new MysqlUuid\Formats\Binary());
        $categoryVideo = $menu->getAdapter()->fetchRow("select * from category where slug = 'videos'");
        $menu->insert([
            'menu_uuid'     => $mysqlUuid,
            'menu_id'       => $id,
            'title'         => 'Videos',
            'is_active'     => true,
            'is_in_header'  => true,
            'is_in_footer'  => true,
            'is_in_side'    => false,
            'order_no'      => 2,
            'article_uuid'  => null,
            'category_uuid' => $categoryVideo['category_uuid']
        ])->save();

        // Insert events category in Menu
        $id            = $faker->uuid;
        $mysqlUuid     = (new MysqlUuid\Uuid($id))->toFormat(new MysqlUuid\Formats\Binary());
        $categoryVideo = $menu->getAdapter()->fetchRow("select * from category where slug = 'events'");
        $menu->insert([
            'menu_uuid'     => $mysqlUuid,
            'menu_id'       => $id,
            'title'         => 'Events',
            'is_active'     => true,
            'is_in_header'  => true,
            'is_in_footer'  => true,
            'is_in_side'    => false,
            'order_no'      => 3,
            'article_uuid'  => null,
            'category_uuid' => $categoryVideo['category_uuid']
        ])->save();

        // Insert link to external web site
        $id            = $faker->uuid;
        $mysqlUuid     = (new MysqlUuid\Uuid($id))->toFormat(new MysqlUuid\Formats\Binary());
        $categoryVideo = $menu->getAdapter()->fetchRow("select * from category where slug = 'events'");
        $menu->insert([
            'menu_uuid'     => $mysqlUuid,
            'menu_id'       => $id,
            'title'         => 'PHPSerbia Rulz',
            'is_active'     => true,
            'is_in_header'  => true,
            'is_in_footer'  => true,
            'is_in_side'    => false,
            'order_no'      => 4,
            'href'          => 'http://phpsrbija.rs',
            'article_uuid'  => null,
            'category_uuid' => null
        ])->save();
    }
}