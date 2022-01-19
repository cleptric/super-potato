<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class VatsimSso extends AbstractMigration
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
            ->removeIndexByName('username')
            ->update();

        $this->table('users')
            ->removeColumn('password')
            ->removeColumn('username')
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
                    'username',
                ],
                [
                    'name' => 'username',
                    'unique' => true,
                ]
            )
            ->update();
    }
}
