<?php

use Phinx\Migration\AbstractMigration;
use Core\Entity\ArticleType;
use MysqlUuid\Formats\Binary;
use MysqlUuid\Uuid;

class Events extends AbstractMigration
{
    public function up()
    {
        $this->table('article_events', ['id' => false])
            ->addColumn('article_uuid', 'binary', ['limit' => 16])
            ->addColumn('title', 'text')
            ->addColumn('sub_title', 'text')
            ->addColumn('body', 'text')
            //
            ->addColumn('featured_img', 'text')
            ->addColumn('main_img', 'text')
            ->addColumn('longitude', 'text')
            ->addColumn('latitude', 'text')
            //
            ->addForeignKey('article_uuid', 'articles', 'article_uuid', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();

        $ids  = [];
        $rows = $this->fetchAll('select admin_user_uuid from admin_users;');
        foreach($rows as $r){
            $ids[] = $r['admin_user_uuid'];
        }

        $faker = Faker\Factory::create();
        $count = rand(250, 300);
        for($i = 0; $i < $count; $i++){
            $id        = $faker->uuid;
            $mysqluuid = (new Uuid($id))->toFormat(new Binary());
            $title     = $faker->sentence(5, 15);

            $article = [
                'article_uuid'    => $mysqluuid,
                'article_id'      => $id,
                'slug'            => strtolower(trim(preg_replace('~[^\pL\d]+~u', '-', $title), '-')),
                'status'          => 1,
                'admin_user_uuid' => $ids[array_rand($ids)],
                'type'            => ArticleType::EVENT
            ];

            $post = [
                'article_uuid' => $mysqluuid,
                'title'        => 'Event: ' . $title,
                'body'         => $faker->paragraph(15),
                'longitude'    => $faker->longitude,
                'latitude'     => $faker->latitude,
                'main_img'     => 'xxx',
                'featured_img' => 'xxx'
            ];

            $this->insert('articles', $article);
            $this->insert('article_events', $post);
        }
    }

    public function down()
    {
        $this->dropTable('article_events');
    }
}
