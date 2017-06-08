<?php

use Phinx\Seed\AbstractSeed;
use UploadHelper\Upload;

class AdminUsers extends AbstractSeed
{

    /**
     * Upload and prepare for DB insert several images
     */
    public function getImages($faker, $type = 'people', $width = 400, $height = 400)
    {
        $images = [];
        $conf   = include __DIR__ . "/../../../config/autoload/local.php";
        $p      = $conf['upload']['public_path'];
        $upload = new Upload($p, '');

        for($i = 0; $i < 5; $i++) {
            $filename = md5(rand()) . '.jpg';
            $path     = $p . $filename[0] . '/' . $filename[1] . '/' . $filename[2] . '/' . $filename;
            $upload->getPath($filename); // create sub folders
            $img = file_get_contents($faker->imageUrl(400, 400, $type));
            file_put_contents($path, $img);

            $images[] = $upload->getWebPath($filename);
        }

        return $images;
    }

    public function run()
    {
        $faker         = Faker\Factory::create();
        $users         = $this->table('admin_users');
        $count         = rand(100, 150);
        $faceImages    = $this->getImages($faker, 'people');
        $profileImages = $this->getImages($faker, 'fashion');

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
                'face_img'        => $faceImages[rand(0, (count($faceImages) - 1))],
                'profile_img'     => $profileImages[rand(0, (count($profileImages) - 1))]
            ];

            $users->insert($data)->save();
        }
    }
}
