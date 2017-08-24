<?php

use Core\Entity\ArticleType;
use MysqlUuid\Formats\Binary;
use MysqlUuid\Uuid;
use Phinx\Migration\AbstractMigration;

class ArticleDiscussions extends AbstractMigration
{
    public function up()
    {
        $this->table('article_discussions', ['id' => false])
            ->addColumn('article_uuid', 'binary', ['limit' => 16])
            ->addColumn('title', 'text')
            ->addColumn('body', 'text')
            ->addForeignKey('article_uuid', 'articles', 'article_uuid', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();

        //        $this->insertDummyData();
    }

    public function down()
    {
        $this->dropTable('article_discussions');
    }

    private function insertDummyData()
    {
        $ids = [];
        $rows = $this->fetchAll('select admin_user_uuid from admin_users;');
        foreach ($rows as $r) {
            $ids[] = $r['admin_user_uuid'];
        }

        $faker = Faker\Factory::create();
        $count = rand(250, 300);
        for ($i = 0; $i < $count; $i++) {
            $id = $faker->uuid;
            $mysqluuid = (new Uuid($id))->toFormat(new Binary());
            $title = $faker->sentence(5, 15);

            $article = [
                'article_uuid'    => $mysqluuid,
                'article_id'      => $id,
                'slug'            => strtolower(trim(preg_replace('~[^\pL\d]+~u', '-', $title), '-')),
                'status'          => 1,
                'admin_user_uuid' => $ids[array_rand($ids)],
                'type'            => ArticleType::DISCUSSION,
            ];

            $post = [
                'article_uuid' => $mysqluuid,
                'title'        => 'Discussion: '.$title,
                'body'         => $faker->paragraph(15),
            ];

            $this->insert('articles', $article);
            $this->insert('article_discussions', $post);
        }
    }
}
