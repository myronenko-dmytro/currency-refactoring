<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Operation;

use Myronenkod\TestProject\Config;
use Myronenkod\TestProject\Console;
use Myronenkod\TestProject\Retrivers\FileDataRetriver;
use Myronenkod\TestProject\Services\BinlistLookupLimitService;
use Myronenkod\TestProject\Services\BinlistLookupService;
use Myronenkod\TestProject\Services\ExchangeRatesService;
use Myronenkod\TestProject\Services\FeeCalculatorService;
use Myronenkod\TestProject\Views\TableView;

class CalculateFee
{
    public function __construct(private Config $config, private Console $console)
    {
    }

    public function calculate()
    {
        $client = new \GuzzleHttp\Client([
            'verify' => false
        ]);

        $binlistLookupService = new BinlistLookupLimitService(
            new BinlistLookupService($client, $this->config),
            $this->config
        );

        $exchangeService = new ExchangeRatesService($client, $this->config);
        $feeCalculator = new FeeCalculatorService($exchangeService, $binlistLookupService, $this->config);

        $filePath = $this->console->getArg(1);
        $currency = $this->console->getArg(2);

        $dataRetriver = new FileDataRetriver($filePath);

        (new TableView())->show(
            $feeCalculator->handle($dataRetriver, $currency)
        );
    }
}