<?php

use Phinx\Seed\AbstractSeed;

class ACategory extends AbstractSeed
{

    public function run()
    {
        $faker    = Faker\Factory::create();
        $category = $this->table('category');
        $count    = rand(5, 10);

        for($i = 0; $i < $count; $i++) {
            $id           = $faker->uuid;
            $mysqlUuid    = (new MysqlUuid\Uuid($id))->toFormat(new MysqlUuid\Formats\Binary());
            $categoryName = $faker->name;

            $data = [
                'category_uuid' => $mysqlUuid,
                'category_id'   => $id,
                'name'          => $categoryName,
                'slug'          => preg_replace('/[^a-z0-9]/i', '-', strtolower($categoryName)),
                'type'          => \Article\Entity\ArticleType::POST
            ];

            $category->insert($data)->save();
        }

        // Insert special category - videos
        $id        = $faker->uuid;
        $mysqlUuid = (new MysqlUuid\Uuid($id))->toFormat(new MysqlUuid\Formats\Binary());
        $category->insert([
            'category_uuid' => $mysqlUuid,
            'category_id'   => $id,
            'name'          => 'Videos',
            'slug'          => 'videos',
            'type'          => \Article\Entity\ArticleType::VIDEO
        ])->save();

        // Insert special category - events
        $id        = $faker->uuid;
        $mysqlUuid = (new MysqlUuid\Uuid($id))->toFormat(new MysqlUuid\Formats\Binary());
        $category->insert([
            'category_uuid' => $mysqlUuid,
            'category_id'   => $id,
            'name'          => 'Events',
            'slug'          => 'events',
            'type'          => \Article\Entity\ArticleType::EVENT
        ])->save();
    }
}
