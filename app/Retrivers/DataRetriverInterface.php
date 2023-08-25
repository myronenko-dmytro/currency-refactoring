<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Retrivers;

use Myronenkod\TestProject\ValueObjects\TransactionInfo;

interface DataRetriverInterface extends \Iterator
{
    public function current(): TransactionInfo;
}