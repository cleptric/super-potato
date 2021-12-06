<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MetarFixture
 */
class MetarFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'metar';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '817e9bd9-862e-41c7-8743-dfd84f9a0afa',
                'airport_id' => '9867bac3-51c6-42ce-9baa-f0f03a5e5458',
                'raw_metar' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'qnh_value' => 1,
                'qnh_unit' => 'Lorem ipsum dolor sit amet',
                'qnh_trend' => 'Lorem ipsum dolor sit amet',
                'mean_direction' => 1,
                'is_variable' => 1,
                'mean_speed' => 1,
                'speed_variations' => 1,
                'wind_shear_runways' => 'Lorem ipsum dolor sit amet',
                'wind_shear_all_runways' => 1,
                'conditions' => 'Lorem ipsum dolor sit amet',
                'rvr' => '',
                'created' => '2021-12-04 05:47:36',
            ],
        ];
        parent::init();
    }
}
