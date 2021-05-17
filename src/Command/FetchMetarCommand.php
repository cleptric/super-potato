<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\Vatsim\MetarService;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Throwable;

class FetchMetarCommand extends Command
{
    /**
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);

        return $parser;
    }

    /**
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|void|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        while (true) {
            try {
                $feedService = new MetarService();
                $feedService->fetchMetar();
                $feedService->persistMetar();
            } catch (Throwable $t) {
                // do nothing
            }

            sleep(60);
        }
    }
}
