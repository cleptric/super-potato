<?php
declare(strict_types=1);

namespace App\WebSockets;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use SplObjectStorage;

class Pusher implements MessageComponentInterface
{
    /**
     * @var \SplObjectStorage
     */
    protected $_clients;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_clients = new SplObjectStorage();
    }

    /**
     * @param \Ratchet\ConnectionInterface $connection Connection
     * @return void
     */
    public function onOpen(ConnectionInterface $connection)
    {
        $this->_clients->attach($connection);

        echo "New connection! ({ $connection->resourceId })\n";
    }

    /**
     * @param \Ratchet\ConnectionInterface $connection Connection
     * @return void
     */
    public function onClose(ConnectionInterface $connection)
    {
        $this->_clients->detach($connection);

        echo "Connection { $connection->resourceId } has disconnected\n";
    }

    /**
     * @param \Ratchet\ConnectionInterface $connection Connection
     * @param \Exception $e Exception
     * @return void
     */
    public function onError(ConnectionInterface $connection, Exception $e)
    {
        echo "An error has occurred: { $e->getMessage() }\n";

        $connection->close();
    }

    /**
     * @param \Ratchet\ConnectionInterface $connection Connection
     * @param string $message Message
     * @return void
     */
    public function onMessage(ConnectionInterface $connection, $message)
    {
        // We do not allow clients to send messages
        $connection->close();
    }

    /**
     * @param string $data Data
     * @return void
     */
    public function onBroadcast(string $data)
    {
        echo "Broadcast: { $data }\n";

        foreach ($this->_clients as $client) {
            $client->send($data);
        }
    }
}
