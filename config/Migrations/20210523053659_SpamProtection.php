<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class SpamProtection extends AbstractMigration
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

        $this->table('airports')
            ->addColumn('closed_runways_timeout', 'datetime', [
                'after' => 'closed_runways',
                'default' => 'CURRENT_TIMESTAMP',
                'length' => null,
                'null' => true,
            ])
            ->addColumn('missed_approach_timeout', 'datetime', [
                'after' => 'missed_approach',
                'default' => 'CURRENT_TIMESTAMP',
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

        $this->table('airports')
            ->removeColumn('closed_runways_timeout')
            ->removeColumn('missed_approach_timeout')
            ->update();
    }
}
