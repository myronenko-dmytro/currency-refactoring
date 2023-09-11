<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Services;

use Myronenkod\TestProject\Config;
use Myronenkod\TestProject\Entities\Transaction;
use Myronenkod\TestProject\Retrivers\DataRetriverInterface;

class FeeCalculatorService
{
    public function __construct(
        private ExchangeRatesServiceInterface $exchangeRatesService,
        private BinlistLookupServiceInterface $binlistLookupService,
        private Config $config
    ) {
    }

    public function handle(DataRetriverInterface $dataRetriver, $currency): array
    {
        $rates = $this->exchangeRatesService->handle($currency);

        $feeList = [];
        foreach($dataRetriver as $transactionInfo) {
            $issuerInfo = $this->binlistLookupService->lookup($transactionInfo->getBin());

            $transaction = new Transaction(
                $transactionInfo->getAmount(),
                $transactionInfo->getCurrency(),
                $issuerInfo
            );

            $feeList[] = $transaction->calculateCommission(
                $rates,
                $this->config->inEuComission(),
                $this->config->outOfEuCommision()
            );
        }

        return $feeList;
    }
}