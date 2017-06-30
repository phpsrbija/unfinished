<?php

use Phinx\Migration\AbstractMigration;

class Menu extends AbstractMigration
{

    public function up()
    {
        $this->table('menu', ['id' => false, 'primary_key' => 'menu_uuid'])
            ->addColumn('menu_uuid', 'binary', ['limit' => 16])
            ->addColumn('menu_id', 'text')
            ->addColumn('parent_id', 'text', ['null' => true])
            ->addColumn('title', 'text')
            ->addColumn('href', 'text', ['null' => true])
            ->addColumn('is_active', 'boolean', ['default' => false])
            ->addColumn('is_in_header', 'boolean', ['default' => true])
            ->addColumn('is_in_footer', 'boolean', ['default' => true])
            ->addColumn('is_in_side', 'boolean', ['default' => true])
            ->addColumn('order_no', 'integer', ['default' => 0])
            ->addColumn('created_at', 'datetime', ['null' => true])
            //->addForeignKey('parent_id', 'menu', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION']) # we can not add constraints
            ->addColumn('page_uuid', 'binary', ['limit' => 16, 'null' => true])
            ->addColumn('category_uuid', 'binary', ['limit' => 16, 'null' => true])
            ->addForeignKey('page_uuid', 'page', 'page_uuid', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('category_uuid', 'category', 'category_uuid', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
    }

    public function down()
    {
        $this->dropTable('menu');
    }
}
