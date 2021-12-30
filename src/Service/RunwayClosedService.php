<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\Airport;
use App\Traits\ZMQContextTrait;
use Authorization\IdentityInterface;
use Cake\Datasource\ModelAwareTrait;
use Cake\I18n\FrozenTime;
use Cake\Utility\Hash;

class RunwayClosedService
{
    use ModelAwareTrait;
    use ZMQContextTrait;

    public function __construct()
    {
        $this->loadModel('Airports');
    }

    public function toggleRunwayClosed(Airport $airport, string $runways, IdentityInterface $user): void
    {
        $data = (array)$airport->closed_runways;
        $closedRunwaysTimeout = new FrozenTime();
        $logsService = new LogsService();

        $key = array_search($runways, $data);
        if ($key !== false) {
            unset($data[$key]);
            $data = array_values($data);

            $logsService->createLog($user, $airport, LogsService::TYPE_OPENED_RUNWAY);

            $this->pushMessage('runway-reopened', $airport->icao);
        } else {
            $data = Hash::merge($data, $runways);
            $closedRunwaysTimeout = new FrozenTime(Airport::RUNWAY_CLOSED_TIMEOUT);

            $logsService->createLog($user, $airport, LogsService::TYPE_CLOSED_RUNWAY);

            $this->pushMessage('runway-closed', $airport->icao);
        }

        $airport = $this->Airports->patchEntity($airport, [
            'closed_runways' => $data,
            'closed_runways_timeout' => $closedRunwaysTimeout,
        ], [
            'accessibleFields' => [
                'closed_runways' => true,
                'closed_runways_timeout' => true,
            ],
        ]);

        $this->Airports->save($airport);

        $this->pushMessage('refresh');
    }
}
