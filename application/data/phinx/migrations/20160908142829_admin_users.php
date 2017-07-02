<?php

use MysqlUuid\Formats\Binary;
use MysqlUuid\Uuid;
use Phinx\Migration\AbstractMigration;

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

        // Insert one default admin user with password testtest
        $faker = Faker\Factory::create();
        $id = $faker->uuid;
        $mysqlUuid = (new Uuid($id))->toFormat(new Binary());

        $this->insert('admin_users', [
            'admin_user_uuid' => $mysqlUuid,
            'admin_user_id'   => $id,
            'first_name'      => 'Unfinished',
            'last_name'       => 'Admin',
            'email'           => 'admin@unfinished.com',
            'password'        => '$2y$10$jhGH8RXl269ho1CrLaDiregVuW84HegLHmBFUCKTgDQTH2XgPZyBK',
            'status'          => 1,
            'face_img'        => $this->getImage($faker, 'people'),
            'profile_img'     => $this->getImage($faker, 'sports'),
        ]);
    }

    public function down()
    {
        $this->dropTable('admin_users');
    }

    private function getImage($faker, $type = 'people', $width = 400, $height = 400)
    {
        $conf = include __DIR__.'/../../../config/autoload/local.php';
        $p = $conf['upload']['public_path'];
        $upload = new \UploadHelper\Upload($p, '');
        $filename = md5(rand()).'.jpg';
        $path = $p.$filename[0].'/'.$filename[1].'/'.$filename[2].'/'.$filename;
        $upload->getPath($filename); // create sub folders
        $img = file_get_contents($faker->imageUrl(400, 400, $type));
        file_put_contents($path, $img);

        return $upload->getWebPath($filename);
    }
}
