<?php

namespace Tests\Services;

use Myronenkod\TestProject\Entities\IssuerInfo;
use Myronenkod\TestProject\Entities\Rates;
use Myronenkod\TestProject\Exceptions\RateForCountryCodeException;
use Myronenkod\TestProject\Retrivers\ConcreteDataRetriver;
use Myronenkod\TestProject\Services\BinlistLookupServiceInterface;
use Myronenkod\TestProject\Services\ExchangeRatesService;
use Myronenkod\TestProject\Services\FeeCalculatorService;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\BinlistMock;
use Tests\Mocks\ExchangeRateMock;

class FeeCalculatorServiceTest extends TestCase
{
    public function testSuccess()
    {
        $mock = $this->createMock(ExchangeRatesService::class);
        $mock->method("handle")->willReturn(new Rates(ExchangeRateMock::get()));

        $binlistMock = $this->createMock(BinlistLookupServiceInterface::class);

        $binlistMock->method('lookup')->willReturn(new IssuerInfo(BinlistMock::get()));

        $dataRetriver = new ConcreteDataRetriver($this->getPath());

        $feeCalculator = new FeeCalculatorService($mock, $binlistMock);

        $data = $feeCalculator->handle($dataRetriver, 'EUR');

        $eurResult = 100.00 / 1 * 0.01;
        $usdResult = 50.00 / 1 * 0.02;

        $this->assertEquals($data[0], $eurResult);
        $this->assertEquals($data[1], $usdResult);
    }

    public function getPath() {
        return join(DIRECTORY_SEPARATOR, [getcwd(),"Tests", "Mocks", "Raw", 'success.txt']);

    }

    public function testRateNotAvaileble()
    {
        $exchageMock = $this->createMock(ExchangeRatesService::class);
        $exchangeRatesRaw = ExchangeRateMock::get();
        $exchangeRatesRaw['rates'] = [];

        $exchageMock->method("handle")->willReturn(new Rates($exchangeRatesRaw));

        $binlistMock = $this->createMock(BinlistLookupServiceInterface::class);
        $binlistMock->method('lookup')->willReturn(new IssuerInfo(BinlistMock::get()));


        $dataRetriver = new ConcreteDataRetriver($this->getPath());

        $feeCalculator = new FeeCalculatorService($exchageMock, $binlistMock);

        $exceptionRaised = false;
        try {
            $feeCalculator->handle($dataRetriver, 'EUR');
        } catch(RateForCountryCodeException $exception) {
            $exceptionRaised = true;
        }

        $this->assertTrue($exceptionRaised);
    }
}