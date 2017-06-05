<?php

use Phinx\Migration\AbstractMigration;

class ArticlePosts extends AbstractMigration
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
            ->addColumn('has_layout', 'boolean', ['default' => true])
            ->addColumn('is_homepage', 'boolean', ['default' => false])
            ->addForeignKey('article_uuid', 'articles', 'article_uuid', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
    }

    public function down()
    {
        $this->dropTable('article_posts');
    }
}

