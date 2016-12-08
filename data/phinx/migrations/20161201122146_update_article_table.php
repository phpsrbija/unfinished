<?php

use Phinx\Migration\AbstractMigration;

class UpdateArticleTable extends AbstractMigration
{
    public function up()
    {
        $this->table('articles')
            ->addColumn('body', 'text')
            ->addColumn('lead', 'text')
            ->addColumn('status', 'integer')
            ->addColumn('user_uuid', 'binary', ['limit' => 16])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->update();
    }

    public function down()
    {
        $this->table('articles')
            ->removeColumn('body')
            ->removeColumn('lead')
            ->removeColumn('status')
            ->removeColumn('user_uuid')
            ->removeColumn('created_at');
    }
}
