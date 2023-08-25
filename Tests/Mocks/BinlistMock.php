<?php

namespace Tests\Mocks;

class BinlistMock
{
    public static function get(): array {
        return array (
            'number' =>
                array (
                    'length' => 16,
                    'luhn' => true,
                ),
            'scheme' => 'visa',
            'type' => 'debit',
            'brand' => 'Visa/Dankort',
            'prepaid' => false,
            'country' =>
                array (
                    'numeric' => '208',
                    'alpha2' => 'DK',
                    'name' => 'Denmark',
                    'emoji' => '🇩🇰',
                    'currency' => 'DKK',
                    'latitude' => 56,
                    'longitude' => 10,
                ),
            'bank' =>
                array (
                    'name' => 'Jyske Bank',
                    'url' => 'www.jyskebank.dk',
                    'phone' => '+4589893300',
                    'city' => 'Hjørring',
                ),
        );
    }
}