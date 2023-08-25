<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Services;

use Myronenkod\TestProject\Entities\RatesInterface;

interface ExchangeRatesServiceInterface
{
    public function handle(string $base = 'EUR'): RatesInterface;
}