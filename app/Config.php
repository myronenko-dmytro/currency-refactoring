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

    public function getBinlistUrl(): string
    {
        return "https://lookup.binlist.net/";
    }

    public function getExchangeRateUrl(): string
    {
        return "http://api.exchangeratesapi.io/v1/latest";
    }

    public function inEuComission(): float
    {
        return 0.01;
    }

    public function outOfEuCommision(): float
    {
        return 0.02;
    }
}