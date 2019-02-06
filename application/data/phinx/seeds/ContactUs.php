<?php

use Phinx\Seed\AbstractSeed;

/**
 * Class ContactUs
 *
 * @package ContactUs
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class ContactUs extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $table = $this->table('contact_us');

        for ($x = 0; $x <= 5; $x++) {
            $id = $faker->uuid;
            $mysqlUuid = (new MysqlUuid\Uuid($id))->toFormat(new MysqlUuid\Formats\Binary());
            $table->insert(
                [
                    'contact_uuid' => $mysqlUuid,
                    'contact_id'   => $id,
                    'name'         => $faker->name,
                    'email'        => $faker->companyEmail,
                    'phone'        => $faker->phoneNumber,
                    'subject'      => 'We\'r contacting you because of...',
                    'body'         => $faker->text,
                ]
            )->save();
        }
    }
}