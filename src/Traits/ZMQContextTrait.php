<?php
declare(strict_types=1);

namespace App\Traits;

use ZMQ;
use ZMQContext;

trait ZMQContextTrait
{
    public function pushMessage(string $type, ?string $icao = null)
    {
        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
        $socket->connect(env('ZMQ_SERVER'));

        $data['type'] = $type;
        if (!empty($icao)) {
            $data['icao'] = strtolower($icao);
        }

        $socket->send(json_encode($data));
    }
}
