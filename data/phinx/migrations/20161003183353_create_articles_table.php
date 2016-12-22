<?php
use Phinx\Migration\AbstractMigration;

class CreateArticlesTable extends AbstractMigration
{
    public function up()
    {
        $this->table('articles', ['id' => false, 'primary_key' => 'article_uuid'])
            ->addColumn('article_uuid', 'binary', ['limit' => 16])
            ->addColumn('title', 'text')
            ->addColumn('slug', 'text')
            ->addColumn('type', 'integer')
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('published_at', 'datetime')
            ->addColumn('body', 'text')
            ->addColumn('lead', 'text')
            ->addColumn('status', 'integer')
            ->addColumn('user_uuid', 'binary', ['limit' => 16])
            ->addIndex('type', ['name' => 'type_INDEX'])
            ->addIndex('published_at', ['name' => 'published_at_INDEX'])
            ->create();
    }

    public function down()
    {
        $this->dropTable('articles');
    }
}
