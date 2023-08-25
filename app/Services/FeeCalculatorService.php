<?php

namespace Myronenkod\TestProject\Services;

use Myronenkod\TestProject\Entities\Transaction;
use Myronenkod\TestProject\Retrivers\DataRetriverInterface;

class FeeCalculatorService
{
    public function __construct(
        private ExchangeRatesService $exchangeRatesService,
        private BinlistLookupServiceInterface $binlistLookupService
    ) {
    }

    public function handle(DataRetriverInterface $dataRetriver, $currency): array
    {
        $rates = $this->exchangeRatesService->handle($currency);

        $feeList = [];
        foreach($dataRetriver as $transactionInfo) {
            $issuerInfo = $this->binlistLookupService->lookup($transactionInfo->getBin());

            $transaction = new Transaction($transactionInfo->getAmount(), $transactionInfo->getCurrency(), $issuerInfo);

            $feeList[] = $transaction->calculateFee($rates);
        }

        return $feeList;
    }
}