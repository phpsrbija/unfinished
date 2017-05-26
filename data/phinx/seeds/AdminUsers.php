<?php

use Phinx\Seed\AbstractSeed;

class AdminUsers extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $users = $this->table('admin_users');
        $count = rand(100, 150);

        for($i = 0; $i < $count; $i++) {
            $id        = $faker->uuid;
            $mysqluuid = (new MysqlUuid\Uuid($id))->toFormat(new MysqlUuid\Formats\Binary());

            $data = [
                'admin_user_uuid' => $mysqluuid,
                'admin_user_id'   => $id,
                'email'           => $faker->email,
                'first_name'      => $faker->firstName,
                'last_name'       => $faker->lastName,
                'password'        => '$2y$10$jhGH8RXl269ho1CrLaDiregVuW84HegLHmBFUCKTgDQTH2XgPZyBK', //password = testtest
                'status'          => rand(0, 1),
                'last_login'      => rand(0, 10) === 7 ? null : $faker->dateTimeBetween('-10 days', 'now')->format('Y-m-d H:i:s'),
                'created_at'      => $faker->dateTimeBetween('-20 days', '-10 days')->format('Y-m-d H:i:s'),
            ];

            $users->insert($data)->save();
        }

    }
}
