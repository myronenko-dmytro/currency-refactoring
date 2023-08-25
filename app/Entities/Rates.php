<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Entities;

use Myronenkod\TestProject\Exceptions\RateForCountryCodeException;

class Rates implements RatesInterface
{
    public function __construct(private array $rateData)
    {
        $this->rateData['rates'][$rateData['base']] = 1;
    }

    function get(string $code): float
    {
        if (!isset($this->rateData['rates'][$code])) {
            throw new RateForCountryCodeException("No such rate for such currency code $code");
        }

        return $this->rateData['rates'][$code];
    }
}