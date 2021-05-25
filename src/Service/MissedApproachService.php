<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\Airport;
use Cake\Datasource\ModelAwareTrait;
use Cake\I18n\FrozenTime;
use ZMQContext;
use ZMQ;

class MissedApproachService
{

    use ModelAwareTrait;

    public function __construct()
    {
        $this->loadModel('Airports');
    }

    public function isMissedApproachTriggerable(string $airportIcao): bool
    {
        $airport = $this->Airports->find()
            ->where(['name' => $airportIcao])
            ->first();

        return !($airport->missed_approach_timeout > new FrozenTime());
    }

    public function toggleMissedApproach(string $airportIcao): void
    {
        $airport = $this->Airports->find()
            ->where(['name' => $airportIcao])
            ->first();

        $missedApproach = $airport->missed_approach;
        $missedApproachTimeout = new FrozenTime();

        if ($missedApproach === false) {
            $missedApproach = true;
            $missedApproachTimeout = new FrozenTime(Airport::MISSED_APPROACH_TIMEOUT);

            $context = new ZMQContext();
            $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
            $socket->connect("tcp://localhost:5555");
            $socket->send(json_encode(['type' => 'missed-approach']));
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

        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
        $socket->connect("tcp://localhost:5555");
        $socket->send(json_encode(['type' => 'refresh']));
    }
}