<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Views;

class TableView
{
    public function show(array $data)
    {
        $output = [];
        $maxlen = 0;
        foreach ($data as $item) {
            $str = (string)$item;
            $maxlen = $maxlen < strlen($str) ? strlen($str) : $maxlen;
            $output[] = $str;
        }

        $outputStr = str_repeat("-", $maxlen + 4) . "\r\n";
        foreach ($output as $item) {
            $outputStr .= "| " . $item . str_repeat(' ', $maxlen - strlen($item)) . ' |';
            $outputStr .= "\r\n";
        }
        $outputStr .= str_repeat("-", $maxlen + 4);


        echo $outputStr;
    }
}