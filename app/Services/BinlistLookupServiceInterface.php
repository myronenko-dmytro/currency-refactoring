<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Services;

use Myronenkod\TestProject\Entities\IssuerInfoInterface;

interface BinlistLookupServiceInterface
{
    public function lookup(int $bin): IssuerInfoInterface;
}