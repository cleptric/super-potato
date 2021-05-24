<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveUserInfo extends AbstractMigration
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
            ->removeColumn('email')
            ->removeColumn('username')
            ->removeColumn('password')
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
            ->addColumn('email', 'string', [
                'after' => 'id',
                'default' => null,
                'length' => 255,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'after' => 'email',
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->addColumn('password', 'string', [
                'after' => 'username',
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->update();
    }
}
