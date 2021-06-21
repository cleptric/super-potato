<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\Airport;
use Cake\Datasource\ModelAwareTrait;
use Cake\Utility\Hash;
use ZMQ;
use ZMQContext;

class VisualDepatureService
{
    use ModelAwareTrait;

    public function __construct()
    {
        $this->loadModel('Airports');
    }

    public function toggleVisualDepature(Airport $airport, string $direction): void
    {
        $data = (array)$airport->visual_depatures;
        if (($key = array_search($direction, $data)) !== false) {
            unset($data[$key]);
            $data = array_values($data);
        } else {
            $data = Hash::merge($data, $direction);
        }

        $airport = $this->Airports->patchEntity($airport, [
            'visual_depatures' => $data,
        ], [
            'accessibleFields' => [
                'visual_depatures' => true,
            ],
        ]);

        $this->Airports->save($airport);

        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
        $socket->connect('tcp://localhost:5555');
        $socket->send(json_encode(['type' => 'refresh']));
    }
}
