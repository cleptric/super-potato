<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ControllersFixture
 */
class ControllersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '7e538a78-77c3-40c3-b615-32fd87707b50',
                'user_id' => '1fc302c6-9971-4b91-ba16-92701cddbb7f',
                'callsign' => 'Lorem ipsum dolor sit amet',
                'facility' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-12-06 03:00:26',
                'modified' => '2021-12-06 03:00:26',
            ],
        ];
        parent::init();
    }
}
