<?php
declare(strict_types=1);

namespace App\Traits;

use ZMQContext;
use ZMQ;

trait ZMQContextTrait
{

    public function pushMessage(string $type, ?string $icao = null)
    {
        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
        $socket->connect("tcp://localhost:5555");

        $data['type'] = $type;
        if (!empty($icao)) {
            $data['icao'] = strtolower($icao);
        }

        $socket->send(json_encode($data));
    }
}