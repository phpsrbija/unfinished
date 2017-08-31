<?php

use Phinx\Migration\AbstractMigration;

/**
 * Class ContactUs
 *
 * @package ContactUs
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class ContactUs extends AbstractMigration
{
    public function up()
    {
        $this
            ->table('contact_us', ['id' => false, 'primary_key' => 'contact_uuid'])
            ->addColumn('contact_uuid',  'binary', ['limit' => 16])
            ->addColumn('contact_id',    'text')
            ->addColumn('name',          'text')
            ->addColumn('email',         'text')
            ->addColumn('phone',         'text')
            ->addColumn('subject',       'text')
            ->addColumn('body',          'text')
            ->addColumn('created_at',    'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->create()
        ;
    }


    public function down()
    {
        $this->dropTable('contact_us');
    }
}
