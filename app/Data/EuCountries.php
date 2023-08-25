<?php

namespace Myronenkod\TestProject\Data;

class EuCountries
{
    private static array $countryList = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];

    public static function has(string $countryCode): bool
    {
        return in_array($countryCode, self::$countryList);
    }
}