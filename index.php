<?php
include 'vendor/autoload.php';

$config = new \Myronenkod\TestProject\Config("f2e77f67f4551d5126089b8bb8447967", 1, 60);

$console = new \Myronenkod\TestProject\Console();

$calculateOperation = new \Myronenkod\TestProject\Operation\CalculateFee($config, $console);

$calculateOperation->calculate();


