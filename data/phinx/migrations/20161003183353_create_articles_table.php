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
            ->addColumn('published_at', 'datetime')
            ->addIndex('type', ['name' => 'type_INDEX'])
            ->addIndex('published_at', ['name' => 'published_at_INDEX'])
            ->create();
    }

    public function down()
    {
        $this->dropTable('articles');
    }
}
