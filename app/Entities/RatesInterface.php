<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Entities;

interface RatesInterface
{
    function get(string $code): float;
}