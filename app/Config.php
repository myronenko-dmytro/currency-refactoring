<?php declare(strict_types=1);

namespace Myronenkod\TestProject;

class Config
{
    public function __construct(private string $apiKey, private int $times, private int $sleep)
    {

    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getLookupTimes(): int
    {
        return $this->times;
    }

    public function getSleep(): int
    {
        return $this->sleep;
    }
}