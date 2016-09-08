<?php

use Phinx\Migration\AbstractMigration;

class AdminUser extends AbstractMigration
{
    public function up()
    {
        $this->table('admin_user', ['id' => true])
            ->addColumn('first_name', 'text')
            ->addColumn('last_name', 'text')
            ->addColumn('email', 'text')
            ->addColumn('password', 'text')
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('last_login', 'datetime', ['null' => true])
            ->create();

        //password is: testtest
        $this->execute("insert into admin_user (first_name,last_name,email,password) values ('Unfinished',  'Admin', 'unfinished@admin.com', '$2y$10\$jhGH8RXl269ho1CrLaDiregVuW84HegLHmBFUCKTgDQTH2XgPZyBK')");
    }

    public function down()
    {
        $this->dropTable('admin_user');
    }
}
