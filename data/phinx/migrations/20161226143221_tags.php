<?php

use Phinx\Migration\AbstractMigration;
use MysqlUuid\Formats\Binary;
use MysqlUuid\Uuid;

class Tags extends AbstractMigration
{

    public function up()
    {
        $this->table('tags', ['id' => false, 'primary_key' => 'tag_uuid'])
            ->addColumn('tag_uuid', 'binary', ['limit' => 16])
            ->addColumn('tag_id', 'text')
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
                'tag_uuid' => $mysqluuid,
                'tag_id'   => $id,
                'name'     => $cat['name'],
                'slug'     => $cat['slug'],
            ];

            $this->insert('tags', $data);
        }
    }

    public function down()
    {
        $this->dropTable('tags');
    }

}
