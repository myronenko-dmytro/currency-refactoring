<?php declare(strict_types=1);

namespace Myronenkod\TestProject\ValueObjects;

class TransactionInfo
{
    private int $bin;
    private int $amount;
    private string $currency;

    /**
     * @param int $bin
     * @param int $amount
     * @param string $currency
     */
    public function __construct(int $bin, int $amount, string $currency)
    {
        $this->bin = $bin;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getBin(): int
    {
        return $this->bin;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}