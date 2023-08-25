<?php declare(strict_types=1);

namespace Myronenkod\TestProject;

class Console
{
    public function getArg(int $arg): string
    {
        return $_SERVER['argv'][$arg];
    }
}