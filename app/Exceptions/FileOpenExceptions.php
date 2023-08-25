<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Exceptions;

use \Exception;
use \Throwable;

class FileOpenExceptions extends Exception
{
    public function __construct(string $message = "", int $code = 101, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}