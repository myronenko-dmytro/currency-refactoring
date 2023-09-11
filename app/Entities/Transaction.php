<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Entities;

class Transaction
{
    public function __construct(private float $amount, private string $currency, private IssuerInfo $issuerInfo)
    {
    }

    public function calculateCommission(Rates $rates, float $inEuComission, float $outOfEuCommission): float
    {
        $amountInEur = $this->amount / $rates->get($this->currency);
        $fee = $this->issuerInfo->isEuBased() ? $amountInEur * $inEuComission : $amountInEur * $outOfEuCommission;

        return ceil($fee * 100) / 100;
    }
}