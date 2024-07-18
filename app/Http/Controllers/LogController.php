<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
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
        return $this->showLogs('laravel.log', false, 'Index');
    }

    public function info()
    {
        return $this->showLogs($this->logFiles['info'], false, 'Info');
    }

    public function error()
    {
        return $this->showLogs('laravel.log', true, 'Error');
    }

    public function email()
    {
        return $this->showLogs($this->logFiles['email'], false, 'Email');
    }

    protected function showLogs($fileName, $onlyErrors = false, $logType = 'Index')
    {
        $logFile = storage_path("logs/{$fileName}");
        $logs = File::exists($logFile) ? File::get($logFile) : 'Log file does not exist.';

        $logLines = explode(PHP_EOL, $logs);

        if ($onlyErrors) {
            $logLines = array_filter($logLines, function ($line) {
                return strpos($line, 'local.ERROR') !== false;
            });
        } else {
            $logLines = array_filter($logLines, function ($line) {
                return strpos($line, 'local.ERROR') === false;
            });
        }

        return view('logs.index', compact('logLines', 'logType'));
    }
}
