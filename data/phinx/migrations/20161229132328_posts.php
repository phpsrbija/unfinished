<?php

use Phinx\Migration\AbstractMigration;
use MysqlUuid\Formats\Binary;
use MysqlUuid\Uuid;
use Core\Entity\ArticleType;
use UploadHelper\Upload;

class Posts extends AbstractMigration
{
    public function up()
    {
        $this->table('article_posts', ['id' => false])
            ->addColumn('article_uuid', 'binary', ['limit' => 16])
            ->addColumn('title', 'text')
            ->addColumn('body', 'text')
            ->addColumn('lead', 'text')
            ->addColumn('featured_img', 'text', ['null' => true])
            ->addColumn('main_img', 'text', ['null' => true])
            ->addForeignKey('article_uuid', 'articles', 'article_uuid', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();

        $ids  = [];
        $rows = $this->fetchAll('select admin_user_uuid from admin_users;');
        foreach($rows as $r){
            $ids[] = $r['admin_user_uuid'];
        }

        $faker  = Faker\Factory::create();
        $upload = new Upload('/var/www/unfinished/public/uploads/', '/var/www/unfinished/data/uploads/');
        $count  = rand(25, 300);

        // Download N images and set it randomly to posts
        for($i = 0; $i < 5; $i++){
            $image       = $faker->image();
            $destination = $upload->getPath(basename($image));
            rename($image, $destination);
            $mainImg[] = substr($destination, strlen('/var/www/unfinished/public'));

            $image       = $faker->image();
            $destination = $upload->getPath(basename($image));
            rename($image, $destination);
            $featuredImg[] = substr($destination, strlen('/var/www/unfinished/public'));
        }

        for($i = 0; $i < $count; $i++){
            $id        = $faker->uuid;
            $mysqluuid = (new Uuid($id))->toFormat(new Binary());
            $title     = $faker->sentence(7, 20);

            $article = [
                'article_uuid'    => $mysqluuid,
                'article_id'      => $id,
                'slug'            => strtolower(trim(preg_replace('~[^\pL\d]+~u', '-', $title), '-')),
                'status'          => 1,
                'admin_user_uuid' => $ids[array_rand($ids)],
                'type'            => ArticleType::POST
            ];

            $post = [
                'article_uuid' => $mysqluuid,
                'title'        => $title,
                'body'         => $faker->paragraph(15),
                'lead'         => $faker->paragraph(5),
                'main_img'     => $mainImg[array_rand($mainImg)],
                'featured_img' => $featuredImg[array_rand($featuredImg)]
            ];

            $this->insert('articles', $article);
            $this->insert('article_posts', $post);
        }
    }

    public function down()
    {
        $this->dropTable('article_posts');
    }
}

