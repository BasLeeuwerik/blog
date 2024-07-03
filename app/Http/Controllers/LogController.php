<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Services\LoggingServiceInterface;

class LogController extends Controller
{
    protected $logFiles = [
        'info' => 'info.log',
        'error' => 'error.log',
        'email' => 'email.log',
    ];

    protected $loggingService;

    public function __construct(LoggingServiceInterface $loggingService)
    {
        $this->loggingService = $loggingService;
    }

    public function log($level)
    {
        $message = ucfirst($level) . ' log added';
        $this->loggingService->log($level, $message);

        return response()->json(['status' => 'success', 'message' => $message]);
    }

    public function index()
    {
        return $this->showLogs('laravel.log');
    }

    public function info()
    {
        return $this->showLogs($this->logFiles['info']);
    }

    public function error()
    {
        return $this->showLogs($this->logFiles['error']);
    }

    public function email()
    {
        return $this->showLogs($this->logFiles['email']);
    }

    public function showLogs($fileName)
    {
        $logFile = storage_path("logs/{$fileName}");
        $logs = File::exists($logFile) ? File::get($logFile) : 'Log file does not exist.';

        $logLines = explode(PHP_EOL, $logs);

        return view('logs.index', compact('logLines'));
    }
}
