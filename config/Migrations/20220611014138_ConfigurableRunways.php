<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ConfigurableRunways extends AbstractMigration
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
            ->addColumn('position_x', 'integer', [
                'after' => 'closed',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addColumn('position_y', 'integer', [
                'after' => 'position_x',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addColumn('rotation', 'integer', [
                'after' => 'position_y',
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
            ->removeColumn('position_x')
            ->removeColumn('position_y')
            ->removeColumn('rotation')
            ->update();
    }
}
