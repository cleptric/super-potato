<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\Airport;
use App\Model\Entity\Runway;
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
        $this->loadModel('Runways');
    }

    public function toggleRunwayClosed(Airport $airport, Runway $runway, IdentityInterface $user): void
    {
        $closedRunwaysTimeout = new FrozenTime();
        $logsService = new LogsService();

        $runwayClosed = $runway->closed;

        if ($runwayClosed !== false) {
            $logsService->createLog($user, $airport, LogsService::TYPE_OPENED_RUNWAY);

            $this->pushMessage('runway-reopened', $airport->icao);
        } else {
            $closedRunwaysTimeout = new FrozenTime(Airport::RUNWAY_CLOSED_TIMEOUT);
            $logsService->createLog($user, $airport, LogsService::TYPE_CLOSED_RUNWAY);

            $this->pushMessage('runway-closed', $airport->icao);
        }

        $airport = $this->Airports->patchEntity($airport, [
            'closed_runways_timeout' => $closedRunwaysTimeout,
        ], [
            'accessibleFields' => [
                'closed_runways_timeout' => true,
            ],
        ]);
        $this->Airports->save($airport);

        $runway = $this->Runways->patchEntity($runway, [
            'closed' => !$runwayClosed,
        ], [
            'accessibleFields' => [
                'closed' => true,
            ],
        ]);
        $this->Runways->save($runway);

        $this->pushMessage('refresh');
    }
}
