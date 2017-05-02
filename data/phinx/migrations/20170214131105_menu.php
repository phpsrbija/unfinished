<?php

use Phinx\Migration\AbstractMigration;

class Menu extends AbstractMigration
{

    public function up()
    {
        $this->table('menu', ['id' => true])
            ->addColumn('title', 'text')                    // show in the menu on web site
            ->addColumn('href', 'text', ['null' => true])
            ->addColumn('parent_id', 'integer', ['null' => true])
            //->addColumn('article_id', 'integer', ['null' => true])

            ->addColumn('is_active', 'boolean', ['default' => false])
            ->addColumn('is_in_header', 'boolean', ['default' => true])
            ->addColumn('is_in_footer', 'boolean', ['default' => true])
            ->addColumn('is_in_side', 'boolean', ['default' => true])


            ->addColumn('order_no', 'integer', ['default' => 0])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addForeignKey('parent_id', 'menu', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])

            ->addColumn('article_uuid', 'binary', ['limit' => 16, 'null' => true])
            //->addForeignKey('article_id', 'article', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('article_uuid', 'articles', 'article_uuid', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])


            ->create();
    }

    public function down()
    {
        $this->dropTable('menu');
    }
}
