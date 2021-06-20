<?php
declare(strict_types=1);

namespace App\WebSockets;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use SplObjectStorage;

class Pusher implements MessageComponentInterface
{
    protected $_clients;

    public function __construct()
    {
        $this->_clients = new SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $connection)
    {
        $this->_clients->attach($connection);

        echo "New connection! ({ $connection->resourceId })\n";
    }

    public function onClose(ConnectionInterface $connection)
    {
        $this->_clients->detach($connection);

        echo "Connection { $connection->resourceId } has disconnected\n";
    }

    public function onError(ConnectionInterface $connection, Exception $e)
    {
        echo "An error has occurred: { $e->getMessage() }\n";

        $connection->close();
    }

    public function onMessage(ConnectionInterface $connection, $message)
    {
        // We do not allow clients to send messages
        $connection->close();
    }

    public function onBroadcast(string $data)
    {
        echo "Broadcast: { $data }\n";

        foreach ($this->_clients as $client) {
            $client->send($data);
        }
    }
}
