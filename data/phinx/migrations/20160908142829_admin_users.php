<?php

use Phinx\Migration\AbstractMigration;

class AdminUsers extends AbstractMigration
{
    public function up()
    {
        $this->table('admin_users', ['id' => false, 'primary_key' => 'admin_user_uuid'])
            ->addColumn('admin_user_uuid', 'binary', ['limit' => 16])
            ->addColumn('first_name', 'text')
            ->addColumn('last_name', 'text')
            ->addColumn('email', 'string', ['limit' => 128])
            ->addColumn('password', 'char', ['limit' => 60])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('last_login', 'datetime', ['null' => true])
            ->addIndex(['email'], ['name' => 'email_INDEX'])
            ->create();

        //password is: testtest
        $this->execute("insert into admin_users (admin_user_uuid, first_name,last_name,email,password) values (UNHEX('110E8400E29B11D4A716446655440000'), 'Unfinished',  'Admin', 'unfinished@admin.com', '$2y$10\$jhGH8RXl269ho1CrLaDiregVuW84HegLHmBFUCKTgDQTH2XgPZyBK')");
    }

    public function down()
    {
        $this->dropTable('admin_users');
    }
}
