<?php

namespace Myronenkod\TestProject\Services;

use Myronenkod\TestProject\Entities\IssuerInfo;

interface BinlistLookupServiceInterface
{
    public function lookup(int $bin): IssuerInfo;
}