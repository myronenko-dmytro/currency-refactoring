<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Services;

use GuzzleHttp\Client;
use Myronenkod\TestProject\Config;
use Myronenkod\TestProject\Entities\Rates;
use Myronenkod\TestProject\Entities\RatesInterface;

class ExchangeRatesService implements ExchangeRatesServiceInterface
{
    public function __construct(private Client $client, private Config $config)
    {
    }

    /**
     * This is oup of scope of current task but we can apply cache + Etag to improve prefomance
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(string $base = 'EUR'): RatesInterface
    {
        $response = $this->client->get($this->config->getExchangeRateUrl(), [
            'query' => [
                'access_key' => $this->config->getApiKey(),
                'base' => $base
            ]
        ]);

        return new Rates(json_decode($response->getBody()->getContents(), true));
    }
}