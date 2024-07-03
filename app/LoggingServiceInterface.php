<?php

namespace App;

use Illuminate\Support\Facades\Log;

interface LoggingServiceInterface
{
    public function log($level, $message);
}

class LoggingService implements LoggingServiceInterface
{
    public function log($level, $message)
    {
        Log::channel($level)->log($level, $message);
    }
}
