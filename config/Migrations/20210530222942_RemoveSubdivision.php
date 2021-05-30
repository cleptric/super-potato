<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveSubdivision extends AbstractMigration
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

        $this->table('users')
            ->removeColumn('subdivision')
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

        $this->table('users')
            ->addColumn('subdivision', 'string', [
                'after' => 'full_name',
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->update();
    }
}
