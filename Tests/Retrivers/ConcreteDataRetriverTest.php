<?php declare(strict_types=1);

namespace Tests\Retrivers;

use Myronenkod\TestProject\Exceptions\DataFormatException;
use Myronenkod\TestProject\Exceptions\JsonDecodeException;
use PHPUnit\Framework\TestCase;
use Myronenkod\TestProject\Retrivers\ConcreteDataRetriver;

class ConcreteDataRetriverTest extends TestCase
{
    private array $responseSuccessData = [
        45717360 => [
            45717360,
            100.00,
            "EUR"
        ],
        516793 => [
            516793,
            50.00,
            "USD"
        ]
    ];

    public function testSuccessCase(): void
    {
        $concreteDataRetriver = new ConcreteDataRetriver($this->getIncludePath("success.txt"));

        foreach ($concreteDataRetriver as $item) {

            $this->assertEquals(
                [$item->getBin(), $item->getAmount(), $item->getCurrency()],
                $this->responseSuccessData[$item->getBin()]
            );
        }
    }

    public function testErrorParseJson(): void
    {
        $this->expectException(JsonDecodeException::class);

        $concreteDataRetriver = new ConcreteDataRetriver($this->getIncludePath("invalid-wrong-format.txt"));

        foreach ($concreteDataRetriver as $item) {
            $test = 1;
        }
    }

    public function testErrorFormat(): void
    {
        $this->expectException(DataFormatException::class);
        $this->expectExceptionMessage("Failed fields validation: [bin, amount, currency]");
        $concreteDataRetriver = new ConcreteDataRetriver($this->getIncludePath("invalid-wrong-data.txt"));

        foreach ($concreteDataRetriver as $item) {
            $test = 1;
        }
    }

    private function getIncludePath(string $filename): string
    {
        return join(DIRECTORY_SEPARATOR, [getcwd(),"Tests", "Mocks", "Raw", $filename]);
    }
}