<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Exceptions;

use Exception;
use Throwable;

class RateForCountryCodeException extends Exception
{
    public function __construct(string $message = "", int $code = 102, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}