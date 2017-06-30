<?php

use Phinx\Seed\AbstractSeed;

class ArticleEvents extends AbstractSeed
{
    public function run()
    {
        $adminUsers = new AdminUsers();
        $faker = Faker\Factory::create();
        $articleEvents = $this->table('article_events');
        $articles = $this->table('articles');
        $count = rand(100, 150);
        $mainImages = $adminUsers->getImages($faker, 'city', 1200, 1200);
        $featuredImages = $adminUsers->getImages($faker, 'technics', 600, 600);

        $allUsers = array_column($articleEvents->getAdapter()->fetchAll('select admin_user_uuid from admin_users'), 'admin_user_uuid');
        $allCategory = array_column($articleEvents->getAdapter()->fetchAll(
            'select category_uuid from category where type = '.\Article\Entity\ArticleType::EVENT), 'category_uuid'
        );

        for ($i = 0; $i < $count; $i++) {
            // Insert Article
            $id = $faker->uuid;
            $mysqlUuid = (new MysqlUuid\Uuid($id))->toFormat(new MysqlUuid\Formats\Binary());
            $title = $faker->sentence();
            $userUuid = $allUsers[rand(0, (count($allUsers) - 1))];
            $categoryUuid = $allCategory[rand(0, (count($allCategory) - 1))];
            $data = [
                'article_uuid'      => $mysqlUuid,
                'article_id'        => $id,
                'slug'              => preg_replace('/[^a-z0-9]/i', '-', strtolower($title)),
                'created_at'        => $faker->dateTimeBetween('-20 days', '-5 days')->format('Y-m-d H:i:s'),
                'published_at'      => $faker->dateTimeBetween('-5 days', '+5 days')->format('Y-m-d H:i:s'),
                'type'              => \Article\Entity\ArticleType::EVENT,
                'status'            => rand(0, 1),
                'admin_user_uuid'   => $userUuid,
                'is_wysiwyg_editor' => true,
                'category_uuid'     => $categoryUuid,
            ];

            $articles->insert($data)->save();

            // Insert Article Posts
            $data = [
                'article_uuid' => $mysqlUuid,
                'title'        => $title,
                'sub_title'    => $faker->sentence(),
                'place_name'   => $faker->name,
                'body'         => $faker->paragraph(15),
                'longitude'    => $faker->longitude,
                'latitude'     => $faker->latitude,
                'start_at'     => $faker->dateTimeBetween('now', '+5 days')->format('Y-m-d H:i:s'),
                'end_at'       => $faker->dateTimeBetween('+5 days', '+6 days')->format('Y-m-d H:i:s'),
                'event_url'    => 'https://www.meetup.com/Tokyo-Hello-Kitty-Meetup/',
                'featured_img' => $featuredImages[rand(0, (count($featuredImages) - 1))],
                'main_img'     => $mainImages[rand(0, (count($mainImages) - 1))],
            ];

            $articleEvents->insert($data)->save();
        }
    }
}
