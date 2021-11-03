<?php
declare(strict_types=1);

namespace App\Command;

use App\WebSockets\Pusher;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\Server;
use React\ZMQ\Context;
use ZMQ;

/**
 * Push command.
 */
class PushCommand extends Command
{
    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/4/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|void|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->out('Push shell started');

        $loop = Factory::create();
        $pusher = new Pusher();

        $context = new Context($loop);
        $pull = $context->getSocket(ZMQ::SOCKET_PULL);

        $pull->bind('tcp://127.0.0.1:5555'); // Binding to 127.0.0.1 means the only client that can connect is itself
        $pull->on('message', [$pusher, 'onBroadcast']);

        // Set up our WebSocket server for clients wanting real-time updates
        $webSock = new Server(env('WSS_SERVER'), $loop); // Binding to 0.0.0.0 means remotes can connect
        $server = new IoServer(
            new HttpServer(
                new WsServer(
                    $pusher
                )
            ),
            $webSock
        );

        $loop->run();
    }
}
