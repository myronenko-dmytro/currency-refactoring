<?php

namespace Myronenkod\TestProject\Entities;

class Transaction
{
    public function __construct(private float $amount, private string $currency, private IssuerInfo $issuerInfo)
    {
    }

    public function calculateFee(Rates $rates)
    {
        $amountInEur = $this->amount / $rates->get($this->currency);
        $fee = $this->issuerInfo->isEuBased() ? $amountInEur * 0.01 : $amountInEur + 0.02;
        return round($fee, 2);
    }
}