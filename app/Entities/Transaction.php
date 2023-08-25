<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Entities;

class Transaction
{
    public function __construct(private float $amount, private string $currency, private IssuerInfo $issuerInfo)
    {
    }

    public function calculateCommission(Rates $rates)
    {
        //  if ($value[2] == 'EUR' or $rate == 0)
        $amountInEur = $this->amount / $rates->get($this->currency);
        $fee = $this->issuerInfo->isEuBased() ? $amountInEur * 0.01 : $amountInEur * 0.02;

        return ceil($fee * 100) / 100;
    }
}