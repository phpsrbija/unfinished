<?php

use Phinx\Migration\AbstractMigration;
use MysqlUuid\Formats\Binary;
use MysqlUuid\Uuid;

class Category extends AbstractMigration
{

    public function up()
    {
        $this->table('category', ['id' => false, 'primary_key' => 'category_uuid'])
            ->addColumn('category_uuid', 'binary', ['limit' => 16])
            ->addColumn('category_id', 'text')
            ->addColumn('name', 'text')
            ->addColumn('slug', 'text')
            ->create();

        $faker = Faker\Factory::create();
        $count = rand(5, 15);

        $categories = [
            ['name' => 'Video', 'slug' => 'super-videos'],
            ['name' => 'Blog Posts', 'slug' => 'experts-posts'],
            ['name' => 'Discusions', 'slug' => 'discusions'],
            ['name' => 'Events in region', 'slug' => 'all-events'],
            ['name' => '#meetup', 'slug' => 'region-meetups'],
            ['name' => 'conf2017', 'slug' => 'phpsrbija-conf2017'],
            ['name' => 'Beer', 'slug' => 'after-parties'],
        ];

        foreach($categories as $cat){
            $id        = $faker->uuid;
            $mysqluuid = (new Uuid($id))->toFormat(new Binary());

            $data = [
                'category_uuid' => $mysqluuid,
                'category_id'   => $id,
                'name'          => $cat['name'],
                'slug'          => $cat['slug'],
            ];

            $this->insert('category', $data);
        }
    }

    public function down()
    {
        $this->dropTable('category');
    }

}
