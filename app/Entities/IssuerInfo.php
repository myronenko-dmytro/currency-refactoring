<?php

namespace Myronenkod\TestProject\Entities;

use Myronenkod\TestProject\Data\EuCountries;

class IssuerInfo
{
    public function __construct(readonly private array $data)
    {
    }

    public function isEuBased(): bool
    {
        return EuCountries::has($this->data['country']['alpha2']);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}