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
            ->addColumn('status', 'integer', ['default' => 0])// 0 => not active, 1 = active
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('last_login', 'datetime', ['null' => true])
            ->addIndex(['email'], ['name' => 'email_INDEX'])
            ->create();

        $faker = Faker\Factory::create();
        $count = rand(100, 150);
        for($i = 0; $i < $count; $i++){
            $data = [
                'admin_user_uuid' => $faker->uuid,
                'email'           => $faker->email,
                'first_name'      => $faker->firstName,
                'last_name'       => $faker->lastName,
                'password'        => '$2y$10$jhGH8RXl269ho1CrLaDiregVuW84HegLHmBFUCKTgDQTH2XgPZyBK',//password = testtest
                'status'          => rand(0, 1),
                'last_login'      => rand(0, 10) === 7 ? null : $faker->dateTimeBetween('-10 days', 'now')->format('Y-m-d H:i:s'),
                'created_at'      => $faker->dateTimeBetween('-20 days', '-10 days')->format('Y-m-d H:i:s'),
            ];

            $this->insert('admin_users', $data);
        }

        // Insert default user with password testtest
        $this->execute(
            "insert into admin_users (admin_user_uuid, first_name,last_name,email,password, status) values " .
            "('$faker->uuid', 'Unfinished',  'Admin', 'admin@unfinished.com', '$2y$10\$jhGH8RXl269ho1CrLaDiregVuW84HegLHmBFUCKTgDQTH2XgPZyBK', 1)"
        );
    }

    public function down()
    {
        $this->dropTable('admin_users');
    }
}

