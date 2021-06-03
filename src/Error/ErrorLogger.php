<?php
declare(strict_types=1);
namespace App\Error;

use Cake\Error\ErrorLogger as CakeErrorLogger;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use function Sentry\captureException;

class ErrorLogger extends CakeErrorLogger
{
    public function log(Throwable $exception, ?ServerRequestInterface $request = null): bool
    {
        if (!in_array(get_class($exception), $this->getConfig('skipLog'))) {
            captureException($exception);
        }

        return parent::log($exception, $request);
    }
}
