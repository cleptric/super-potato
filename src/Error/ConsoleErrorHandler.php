<?php
declare(strict_types=1);

namespace App\Error;

use Cake\Error\ConsoleErrorHandler as CakeConsoleErrorHandler;

class ConsoleErrorHandler extends CakeConsoleErrorHandler
{
    protected $_defaultConfig = [
        'log' => true,
        'trace' => false,
        'skipLog' => [],
        'errorLogger' => ErrorLogger::class,
    ];
}
