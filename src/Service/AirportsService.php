<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\Airport;
use App\Traits\ZMQContextTrait;
use Cake\Datasource\ModelAwareTrait;
use Cake\I18n\FrozenTime;

class AirportsService
{
    use ModelAwareTrait;
    use ZMQContextTrait;

    public function __construct()
    {
        $this->loadModel('Airports');
    }

    public function resetState(): void
    {
        $airports = $this->Airports->find()
            ->all();

        foreach ($airports as $airport) {
            $airport = $this->Airports->patchEntity($airport, [
                'visual_depatures' => null,
                'closed_runways' => null,
                'missed_approach' => false,
            ], [
                'accessibleFields' => [
                    'visual_depatures' => true,
                    'closed_runways' => true,
                    'missed_approach' => true,
                ],
            ]);
            $this->Airports->save($airport);
        }

        $this->pushMessage('refresh');
    }

    public function resetMissedApporach(): void
    {
        $airports = $this->Airports->find()
            ->where([
                'missed_approach' => true,
                'missed_approach_timeout <=' => new FrozenTime(Airport::MISSED_APPROACH_RESET),
            ])
            ->toArray();

        foreach ($airports as $airport) {
            $airport = $this->Airports->patchEntity($airport, [
                'missed_approach' => false,
            ], [
                'accessibleFields' => [
                    'missed_approach' => true,
                ],
            ]);
            $this->Airports->save($airport);
        }

        if (!empty($airports)) {
            $this->pushMessage('refresh');
        }
    }
}
