<?php

use Phinx\Migration\AbstractMigration;
use MysqlUuid\Formats\Binary;
use MysqlUuid\Uuid;

class CreateArticlesTable extends AbstractMigration
{
    public function up()
    {
        $this->table('articles', ['id' => false, 'primary_key' => 'article_uuid'])
            ->addColumn('article_uuid', 'binary', ['limit' => 16])
            ->addColumn('article_id', 'text')
            ->addColumn('title', 'text')
            ->addColumn('slug', 'text', ['null' => true])
            ->addColumn('type', 'integer', ['default' => 0])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('published_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('body', 'text')
            ->addColumn('lead', 'text')
            ->addColumn('status', 'integer')
            ->addColumn('admin_user_uuid', 'binary', ['limit' => 16])
            ->addIndex('type', ['name' => 'type_INDEX'])
            ->addIndex('published_at', ['name' => 'published_at_INDEX'])
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
            $data      = [
                'article_uuid'    => $mysqluuid,
                'article_id'      => $id,
                'title'           => $title = $faker->sentence(7, 20),
                'slug'            => strtolower(trim(preg_replace('~[^\pL\d]+~u', '-', $title), '-')),
                'body'            => $faker->paragraph(15),
                'lead'            => $faker->paragraph(5),
                'status'          => 1,
                'admin_user_uuid' => array_rand($ids)
            ];

            $this->insert('articles', $data);
        }
    }

    public function down()
    {
        $this->dropTable('articles');
    }
}
