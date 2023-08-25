<?php

namespace Myronenkod\TestProject\Services;

use GuzzleHttp\Client;
use Myronenkod\TestProject\Entities\IssuerInfo;

class BinlistLookupService implements BinlistLookupServiceInterface
{
    public function __construct(private Client $client)
    {
    }

    public function lookup(int $bin): IssuerInfo
    {
        $response = $this->client->get("https://lookup.binlist.net/$bin", ['json' => true]);

        return new IssuerInfo(json_decode($response->getBody()->getContents(), true));
    }
}