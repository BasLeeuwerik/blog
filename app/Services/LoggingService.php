<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class LoggingService implements LoggingServiceInterface
{
    public function log(string $level, string $message): void
    {
        Log::channel($level)->$level($message);
    }
}
