<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddUserFields extends AbstractMigration
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
            ->addColumn('password', 'string', [
                'after' => 'full_name',
                'default' => null,
                'length' => 255,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'after' => 'password',
                'default' => null,
                'length' => 255,
                'null' => false,
            ])
            ->addIndex(
                [
                    'vatsim_id',
                ],
                [
                    'name' => 'vatsim_id',
                    'unique' => true,
                ]
            )
            ->addIndex(
                [
                    'username',
                ],
                [
                    'name' => 'username',
                    'unique' => true,
                ]
            )
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
            ->removeIndexByName('vatsim_id')
            ->removeIndexByName('username')
            ->update();

        $this->table('users')
            ->removeColumn('password')
            ->removeColumn('username')
            ->update();
    }
}
