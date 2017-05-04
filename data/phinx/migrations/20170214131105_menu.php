<?php

use Phinx\Migration\AbstractMigration;

class Menu extends AbstractMigration
{

    public function up()
    {
        $this->table('menu', ['id' => true])
            ->addColumn('title', 'text')
            ->addColumn('href', 'text', ['null' => true])
            ->addColumn('parent_id', 'integer', ['null' => true])
            ->addColumn('is_active', 'boolean', ['default' => false])
            ->addColumn('is_in_header', 'boolean', ['default' => true])
            ->addColumn('is_in_footer', 'boolean', ['default' => true])
            ->addColumn('is_in_side', 'boolean', ['default' => true])
            ->addColumn('order_no', 'integer', ['default' => 0])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addForeignKey('parent_id', 'menu', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addColumn('article_uuid', 'binary', ['limit' => 16, 'null' => true])
            ->addForeignKey('article_uuid', 'articles', 'article_uuid', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addColumn('category_uuid', 'binary', ['limit' => 16, 'null' => true])
            ->addForeignKey('category_uuid', 'category', 'category_uuid', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
    }

    public function down()
    {
        $this->dropTable('menu');
    }
}
