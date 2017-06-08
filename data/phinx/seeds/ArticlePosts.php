<?php

use Phinx\Seed\AbstractSeed;

class ArticlePosts extends AbstractSeed
{

    public function run()
    {
        $adminUsers     = new AdminUsers;
        $faker          = Faker\Factory::create();
        $articlePosts   = $this->table('article_posts');
        $articles       = $this->table('articles');
        $count          = rand(100, 150);
        $mainImages     = $adminUsers->getImages($faker, 'city', 1200, 1200);
        $featuredImages = $adminUsers->getImages($faker, 'technics', 600, 600);

        $allUsers    = array_column($articlePosts->getAdapter()->fetchAll('select admin_user_uuid from admin_users'), 'admin_user_uuid');
        $allCategory = array_column($articlePosts->getAdapter()->fetchAll('select category_uuid from category'), 'category_uuid');

        for($i = 0; $i < $count; $i++) {
            // Insert Article
            $id           = $faker->uuid;
            $mysqlUuid    = (new MysqlUuid\Uuid($id))->toFormat(new MysqlUuid\Formats\Binary());
            $title        = $faker->sentence();
            $userUuid     = $allUsers[rand(0, (count($allUsers) - 1))];
            $categoryUuid = $allCategory[rand(0, (count($allCategory) - 1))];
            $data         = [
                'article_uuid'      => $mysqlUuid,
                'article_id'        => $id,
                'slug'              => preg_replace('/[^a-z0-9]/i', '-', strtolower($title)),
                'created_at'        => $faker->dateTimeBetween('-20 days', '-5 days')->format('Y-m-d H:i:s'),
                'published_at'      => $faker->dateTimeBetween('-5 days', '+5 days')->format('Y-m-d H:i:s'),
                'type'              => \Article\Entity\ArticleType::POST,
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
                'body'         => $faker->paragraph(15),
                'lead'         => $faker->paragraph(5),
                'featured_img' => $featuredImages[rand(0, (count($featuredImages) - 1))],
                'main_img'     => $mainImages[rand(0, (count($mainImages) - 1))],
                'has_layout'   => true,
            ];

            $articlePosts->insert($data)->save();
        }
    }
}
