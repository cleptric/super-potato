<?php
declare(strict_types=1);
namespace App\Error;

use Cake\Error\ErrorHandler as CakeErrorHandler;
use function Sentry\captureException;

class ErrorHandler extends CakeErrorHandler
{
    protected $_defaultConfig = [
        'log' => true,
        'trace' => false,
        'skipLog' => [],
        'errorLogger' => ErrorLogger::class,
    ];
}
