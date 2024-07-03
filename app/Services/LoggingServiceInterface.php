<?php

namespace App\Services;

interface LoggingServiceInterface
{
    public function log(string $level, string $message): void;
}
