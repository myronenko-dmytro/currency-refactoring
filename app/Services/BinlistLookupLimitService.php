<?php

namespace Myronenkod\TestProject\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Myronenkod\TestProject\Config;
use Myronenkod\TestProject\Entities\IssuerInfo;

class BinlistLookupLimitService implements BinlistLookupServiceInterface
{
    public function __construct(private BinlistLookupServiceInterface $binlistLookupService, private Config $config)
    {
    }

    public function lookup(int $bin): IssuerInfo
    {
        $iteration = 0;
        while (true) {
            try {
                return $this->binlistLookupService->lookup($bin);
            } catch (\Throwable $exception) {
                ++$iteration;

                if ($this->config->getLookupTimes() < $iteration) {
                    throw $exception;
                }

                if ($exception->getCode() === 429) {
                    sleep($this->config->getSleep());
                }
            }
        }
    }
}