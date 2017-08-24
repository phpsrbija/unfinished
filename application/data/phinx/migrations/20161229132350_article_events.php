<?php

use Core\Entity\ArticleType;
use MysqlUuid\Formats\Binary;
use MysqlUuid\Uuid;
use Phinx\Migration\AbstractMigration;
use UploadHelper\Upload;

class ArticleEvents extends AbstractMigration
{
    public function up()
    {
        $this->table('article_events', ['id' => false])
            ->addColumn('article_uuid', 'binary', ['limit' => 16])
            ->addColumn('title', 'text')
            ->addColumn('sub_title', 'text', ['null' => true])
            ->addColumn('place_name', 'text')
            ->addColumn('body', 'text')
            ->addColumn('longitude', 'text')
            ->addColumn('latitude', 'text')
            ->addColumn('featured_img', 'text', ['null' => true])
            ->addColumn('main_img', 'text', ['null' => true])
            ->addColumn('start_at', 'datetime')
            ->addColumn('end_at', 'datetime')
            ->addColumn('event_url', 'text', ['null' => true])
            ->addForeignKey('article_uuid', 'articles', 'article_uuid', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();

        //        $this->insertDummyData();
    }

    public function down()
    {
        $this->dropTable('article_events');
    }

    private function insertDummyData()
    {
        $ids = [];
        $rows = $this->fetchAll('select admin_user_uuid from admin_users;');
        foreach ($rows as $r) {
            $ids[] = $r['admin_user_uuid'];
        }

        $faker = Faker\Factory::create();
        $upload = new Upload('/var/www/unfinished/public/uploads/', '/var/www/unfinished/data/uploads/');
        $count = rand(25, 300);

        // Download N images and set it randomly to the events
        for ($i = 0; $i < 5; $i++) {
            $image = $faker->image();
            $destination = $upload->getPath(basename($image));
            rename($image, $destination);
            $mainImg[] = substr($destination, strlen('/var/www/unfinished/public'));

            $image = $faker->image();
            $destination = $upload->getPath(basename($image));
            rename($image, $destination);
            $featuredImg[] = substr($destination, strlen('/var/www/unfinished/public'));
        }

        for ($i = 0; $i < $count; $i++) {
            $start = rand(1, 20);
            $id = $faker->uuid;
            $mysqluuid = (new Uuid($id))->toFormat(new Binary());
            $title = $faker->sentence(5, 15);

            $article = [
                'article_uuid'    => $mysqluuid,
                'article_id'      => $id,
                'slug'            => strtolower(trim(preg_replace('~[^\pL\d]+~u', '-', $title), '-')),
                'status'          => 1,
                'admin_user_uuid' => $ids[array_rand($ids)],
                'type'            => ArticleType::EVENT,
            ];

            $post = [
                'article_uuid' => $mysqluuid,
                'title'        => 'Event: '.$title,
                'body'         => $faker->paragraph(15),
                'longitude'    => $faker->longitude,
                'latitude'     => $faker->latitude,
                'place_name'   => $faker->sentence(1),
                'main_img'     => $mainImg[array_rand($mainImg)],
                'featured_img' => $featuredImg[array_rand($featuredImg)],
                'start_at'     => date('Y-m-d H:i:s', strtotime("+$start  day +$start hours")),
                'end_at'       => date('Y-m-d H:i:s', strtotime("+$start  day +".($start + rand(1, 5)).' hours')),
            ];

            $this->insert('articles', $article);
            $this->insert('article_events', $post);
        }
    }
}
