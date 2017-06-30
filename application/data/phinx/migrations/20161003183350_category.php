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
            ->addColumn('type', 'integer')  // see Article\Entity\ArticleType
            ->addColumn('title', 'text', ['null' => true])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('main_img', 'text', ['null' => true])
            ->addColumn('is_in_homepage', 'boolean', ['default' => false])
            ->addColumn('is_in_category_list', 'boolean', ['default' => true])
            ->create();
    }

    public function down()
    {
        $this->dropTable('category');
    }

}
