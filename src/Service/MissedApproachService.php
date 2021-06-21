<?php
declare(strict_types=1);

namespace App\Service;

use App\Traits\ZMQContextTrait;
use Authorization\IdentityInterface;
use Cake\Datasource\ModelAwareTrait;
use Cake\I18n\FrozenTime;

class MissedApproachService
{
    use ModelAwareTrait;
    use ZMQContextTrait;

    public function __construct()
    {
        $this->loadModel('Airports');
    }

    public function toggleMissedApproach(Airport $airport, IdentityInterface $user): void
    {
        $missedApproach = $airport->missed_approach;
        $missedApproachTimeout = new FrozenTime();

        if ($missedApproach === false) {
            $missedApproach = true;
            $missedApproachTimeout = new FrozenTime(Airport::MISSED_APPROACH_TIMEOUT);

            (new LogsService())->createLog($user, $airport, LogsService::TYPE_MISSED_APPROACH);

            $this->pushMessage('missed-approach', $airport->name);
        } else {
            $missedApproach = false;
        }

        $airport = $this->Airports->patchEntity($airport, [
            'missed_approach' => $missedApproach,
            'missed_approach_timeout' => $missedApproachTimeout,
        ], [
            'accessibleFields' => [
                'missed_approach' => true,
                'missed_approach_timeout' => true,
            ],
        ]);

        $this->Airports->save($airport);

        $this->pushMessage('refresh');
    }
}
