<?php
declare(strict_types=1);

namespace App\Service;

use Authorization\IdentityInterface;
use App\Model\Entity\Airport;
use App\Service\LogsService;
use Cake\Datasource\ModelAwareTrait;
use Cake\I18n\FrozenTime;
use Cake\Utility\Hash;
use ZMQContext;
use ZMQ;

class RunwayClosedService
{

    use ModelAwareTrait;

    public function __construct()
    {
        $this->loadModel('Airports');
    }

    public function toggleRunwayClosed(Airport $airport, string $runways, IdentityInterface $user): void
    {
        $data = (array)$airport->closed_runways;
        $closedRunwaysTimeout = new FrozenTime();
        $logsService = new LogsService();

        if (($key = array_search($runways, $data)) !== false) {
            unset($data[$key]);
            $data = array_values($data);

            $logsService->createLog($user, $airport, LogsService::TYPE_OPENED_RUNWAY);

            $context = new ZMQContext();
            $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
            $socket->connect("tcp://localhost:5555");
            $socket->send(json_encode(['type' => 'runway-reopened']));
        } else {
            $data = Hash::merge($data, $runways);
            $closedRunwaysTimeout = new FrozenTime(Airport::RUNWAY_CLOSED_TIMEOUT);

            $logsService->createLog($user, $airport, LogsService::TYPE_CLOSED_RUNWAY);

            $context = new ZMQContext();
            $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
            $socket->connect("tcp://localhost:5555");
            $socket->send(json_encode([
                'type' => 'runway-closed',
                'airport' => $airport->name,
            ]));
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

        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
        $socket->connect("tcp://localhost:5555");
        $socket->send(json_encode(['type' => 'refresh']));
    }
}