# How to run 
```
php .\index.php .\transactions.txt EUR
```

**php .\index.php {1} {2}**
Where

{1} - is file with params

{2} - base currency we are working with.


# Notes
1. I was trying not to use any libraries, however there is two exceptions as I've added GUZZLE and phpunit lib.
2. Classes Config, Console, View are as simple as possible and were made for showing abstaction and responsibility separation.
3. Classes CurrencyCodes and EuCountries should be part of internacionalization module and made for simplicity of test task.
5. I intentionally removed this logic since it's imposibble to get rate equal to 0;

    ```if ($value[2] == 'EUR' or $rate == 0)```
# Task description

```
<?php

foreach (explode("\n", file_get_contents($argv[1])) as $row) {

    if (empty($row)) break;
    $p = explode(",",$row);
    $p2 = explode(':', $p[0]);
    $value[0] = trim($p2[1], '"');
    $p2 = explode(':', $p[1]);
    $value[1] = trim($p2[1], '"');
    $p2 = explode(':', $p[2]);
    $value[2] = trim($p2[1], '"}');

    $binResults = file_get_contents('https://lookup.binlist.net/' .$value[0]);
    if (!$binResults)
        die('error!');
    $r = json_decode($binResults);
    $isEu = isEu($r->country->alpha2);

    $rate = @json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true)['rates'][$value[2]];
    if ($value[2] == 'EUR' or $rate == 0) {
        $amntFixed = $value[1];
    }
    if ($value[2] != 'EUR' or $rate > 0) {
        $amntFixed = $value[1] / $rate;
    }

    echo $amntFixed * ($isEu == 'yes' ? 0.01 : 0.02);
    print "\n";
}

function isEu($c) {
    $result = false;
    switch($c) {
        case 'AT':
        case 'BE':
        case 'BG':
        case 'CY':
        case 'CZ':
        case 'DE':
        case 'DK':
        case 'EE':
        case 'ES':
        case 'FI':
        case 'FR':
        case 'GR':
        case 'HR':
        case 'HU':
        case 'IE':
        case 'IT':
        case 'LT':
        case 'LU':
        case 'LV':
        case 'MT':
        case 'NL':
        case 'PO':
        case 'PT':
        case 'RO':
        case 'SE':
        case 'SI':
        case 'SK':
            $result = 'yes';
            return $result;
        default:
            $result = 'no';
    }
    return $result;
}
```

# Requirements for your code

It must have unit tests. If you haven't written any previously, please take the time to learn it before making the task, you'll thank us later.
Unit tests must test the actual results and still pass even when the response from remote services change (this is quite normal, exchange rates change every day). This is best accomplished by using mocking.
As an improvement, add ceiling of commissions by cents. For example, 0.46180... should become 0.47.
It should give the same result as original code in case there are no failures, except for the additional ceiling.
Code should be extendible – we should not need to change existing, already tested functionality to accomplish the following:
Switch our currency rates provider (different URL, different response format and structure, possibly some authentication);
Switch our BIN provider (different URL, different response format and structure, possibly some authentication);
Just to note – no need to implement anything additional. Just structure your code so that we could implement that later on without braking our tests;
It should look as you'd write it yourself in production – consistent, readable, structured. Anything we'll find in the code, we'll treat as if you'd write it yourself. Basically it's better to just look at the existing code and re-write it from scratch. For example, if 'yes'/'no', ugly parsing code or die statements are left in the solution, we'd treat it as an instant red flag.
Use composer to install testing framework and any needed dependencies you'd like to use, also for enabling autoloading.