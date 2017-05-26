<?php

use Phinx\Migration\AbstractMigration;
use MysqlUuid\Formats\Binary;
use MysqlUuid\Uuid;

class AdminUsers extends AbstractMigration
{
    public function up()
    {
        $this->table('admin_users', ['id' => false, 'primary_key' => 'admin_user_uuid'])
            ->addColumn('admin_user_uuid', 'binary', ['limit' => 16])
            ->addColumn('admin_user_id', 'text')
            ->addColumn('first_name', 'text')
            ->addColumn('last_name', 'text')
            ->addColumn('introduction', 'text', ['null' => true])
            ->addColumn('biography', 'text', ['null' => true])
            ->addColumn('email', 'string', ['limit' => 128])
            ->addColumn('password', 'char', ['limit' => 60])
            ->addColumn('status', 'integer', ['default' => 0])// 0 => not active, 1 = active
            ->addColumn('face_img', 'text', ['null' => true])
            ->addColumn('profile_img', 'text', ['null' => true])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('last_login', 'datetime', ['null' => true])
            ->addIndex(['email'], ['name' => 'email_INDEX'])
            ->create();

        // Insert default admin user with password testtest
        $faker = Faker\Factory::create();
        $id        = $faker->uuid;
        $mysqluuid = (new Uuid($id))->toFormat(new Binary());
        $this->execute("insert into admin_users (admin_user_uuid, admin_user_id, first_name,last_name,email,password, status) values " .
            "('$mysqluuid', '$id', 'Unfinished',  'Admin', 'admin@unfinished.com', '$2y$10\$jhGH8RXl269ho1CrLaDiregVuW84HegLHmBFUCKTgDQTH2XgPZyBK', 1)"
        );
    }

    public function down()
    {
        $this->dropTable('admin_users');
    }
}

