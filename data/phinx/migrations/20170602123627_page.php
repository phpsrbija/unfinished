<?php

use Phinx\Migration\AbstractMigration;

class Page extends AbstractMigration
{
    public function change()
    {
        $this->table('page', ['id' => false])
            ->addColumn('page_uuid', 'binary', ['limit' => 16])
            ->addColumn('page_id', 'text')
            ->addColumn('title', 'text')
            ->addColumn('body', 'text')
            ->addColumn('description', 'text')
            ->addColumn('slug', 'text')
            ->addColumn('main_img', 'text', ['null' => true])
            ->addColumn('has_layout', 'boolean', ['default' => true])
            ->addColumn('is_homepage', 'boolean', ['default' => false])
            ->addColumn('is_active', 'boolean', ['default' => false])
            ->addColumn('is_wysiwyg_editor', 'boolean', ['default' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
