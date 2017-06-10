<?php

use Phinx\Seed\AbstractSeed;

class Page extends AbstractSeed
{

    public function run()
    {
        $faker = Faker\Factory::create();
        $page  = $this->table('page');

        // Insert one Page
        $id        = $faker->uuid;
        $mysqlUuid = (new MysqlUuid\Uuid($id))->toFormat(new MysqlUuid\Formats\Binary());
        $title     = $faker->sentence();
        $page->insert([
            'page_uuid'         => $mysqlUuid,
            'page_id'           => $id,
            'title'             => $faker->sentence(),
            'body'              => $faker->paragraph(30),
            'slug'              => trim(preg_replace('/[^a-z0-9]/i', '-', strtolower($title)), '-'),
            'description'       => $faker->paragraph(5),
            'main_img'          => '',
            'has_layout'        => true,
            'is_homepage'       => false,
            'is_wysiwyg_editor' => false,
            'is_active'         => rand(0, 1),
        ])->save();
    }
}
