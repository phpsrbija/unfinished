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
            ->create();
    }

    public function down()
    {
        $this->dropTable('category');
    }

}
