<?php

namespace Tests\Services;

use GuzzleHttp\Exception\RequestException;
use Myronenkod\TestProject\Config;
use Myronenkod\TestProject\Entities\IssuerInfo;
use Myronenkod\TestProject\Services\BinlistLookupLimitService;
use Myronenkod\TestProject\Services\BinlistLookupService;
use Myronenkod\TestProject\Services\BinlistLookupServiceInterface;
use PHPUnit\Framework\MockObject\Stub\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\Mocks\BinlistMock;

class BinlistLookupServiceTest extends TestCase
{
    public function testSuccess(): void
    {
        /** @var BinlistLookupService $binlistLookup */
        $binlistLookup = $this->createMock(BinlistLookupServiceInterface::class);
        $binlistLookup
            ->expects($this->once())
            ->method('lookup')
            ->willReturn(new IssuerInfo(BinlistMock::get()));

        $config = new Config('asdsada', 1, 1);

        $binlistLookupLimitService = new BinlistLookupLimitService($binlistLookup, $config);

        $response = $binlistLookupLimitService->lookup(12314);

        $this->assertEquals(BinlistMock::get(), $response->toArray());
    }

    public function testRetry(): void
    {
        $requestExceptionMock = $this->mockRequest();

        /** @var BinlistLookupService $binlistLookup */
        $binlistLookup = $this->createMock(BinlistLookupServiceInterface::class);
        $binlistLookup->expects($this->exactly(2))->method('lookup')->willReturnOnConsecutiveCalls(
            new Exception($requestExceptionMock),
            new IssuerInfo(BinlistMock::get())
        );

        $config = new Config('asdsada', 1, 1);

        $binlistLimitLookup = new BinlistLookupLimitService($binlistLookup, $config);

        $data = $binlistLimitLookup->lookup(1231231);

        $this->assertEquals(BinlistMock::get(), $data->toArray());
    }

    public function mockRequest() {
        $requestMock = $this->createMock(RequestInterface::class);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(429);

        return new RequestException('Something happened', $requestMock, $responseMock);
    }
}