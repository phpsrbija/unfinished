<?php

use Phinx\Migration\AbstractMigration;

class Newsletter extends AbstractMigration
{

    public function change()
    {
        $this->table('newsletter', ['id' => false])
            ->addColumn('email', 'text')
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
