<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\Vatsim\MetarService;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class FetchMetarCommand extends Command
{
    /**
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|void|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $metarService = new MetarService();
        $metarService->setIo($io);

        while (true) {
            $metarService->getMetar();
            sleep(60);
        }
    }
}
