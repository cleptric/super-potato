<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddRunways extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up()
    {

        $this->table('runways')
            ->addColumn('airport_id', 'uuid', [
                'after' => 'id',
                'default' => null,
                'length' => null,
                'null' => false,
            ])
            ->addColumn('designator', 'string', [
                'after' => 'airport_id',
                'default' => null,
                'length' => 255,
                'null' => false,
            ])
            ->addColumn('closed', 'boolean', [
                'after' => 'designator',
                'default' => '0',
                'length' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'after' => 'closed',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'after' => 'created',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down()
    {

        $this->table('runways')
            ->removeColumn('airport_id')
            ->removeColumn('designator')
            ->removeColumn('closed')
            ->removeColumn('created')
            ->removeColumn('modified')
            ->update();
    }
}
