<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AirportsFixture
 */
class AirportsFixture extends TestFixture
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
                'id' => 'c3d6f09b-d0b6-4e65-bdbb-ddc5f692f725',
                'organization_id' => 'a005c3db-5cd7-4dfb-aba9-c7f264f29d1f',
                'name' => 'Lorem ipsum dolor sit amet',
                'atis_callsign' => 'Lorem ipsum dolor sit amet',
                'atis_depature_runway_pattern' => 'Lorem ipsum dolor sit amet',
                'atis_arrival_runway_pattern' => 'Lorem ipsum dolor sit amet',
                'atis_transition_level_pattern' => 'Lorem ipsum dolor sit amet',
                'atis_time_pattern' => 'Lorem ipsum dolor sit amet',
                'closed_runways_timeout' => '2021-12-06 03:17:29',
                'missed_approach_timeout' => '2021-12-06 03:17:29',
                'created' => '2021-12-06 03:17:29',
                'modified' => '2021-12-06 03:17:29',
                'atis_letter_pattern' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
