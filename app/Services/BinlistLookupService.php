<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Services;

use GuzzleHttp\Client;
use Myronenkod\TestProject\Entities\IssuerInfo;
use Myronenkod\TestProject\Entities\IssuerInfoInterface;

class BinlistLookupService implements BinlistLookupServiceInterface
{
    public function __construct(private Client $client)
    {
    }

    public function lookup(int $bin): IssuerInfoInterface
    {
        $response = $this->client->get("https://lookup.binlist.net/$bin", ['json' => true]);
        $data = json_decode($response->getBody()->getContents(), true);
        return new IssuerInfo($data);
    }
}