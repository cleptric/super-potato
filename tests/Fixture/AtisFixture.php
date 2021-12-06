<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AtisFixture
 */
class AtisFixture extends TestFixture
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
                'id' => 'ab1c59b4-ec1d-45d7-bd07-4bf769c55eb7',
                'airport_id' => '28893873-fe16-49fc-95ed-7dd21d25e3b9',
                'raw_atis' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'atis_letter' => 'Lorem ipsum dolor sit amet',
                'depature_runways' => '',
                'arrival_runways' => '',
                'transition_level' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-12-06 03:17:02',
                'modifed' => '2021-12-06 03:17:02',
            ],
        ];
        parent::init();
    }
}
