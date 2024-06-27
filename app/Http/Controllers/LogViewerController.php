<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class LogViewerController extends Controller
{
    protected $logFiles = [
        'debug' => 'debug.log',
        'info' => 'info.log',
        'warning' => 'warning.log',
        'error' => 'error.log',
        'critical' => 'critical.log',
    ];

    public function index()
    {
        return $this->showLogs('laravel.log');
    }

    public function debug()
    {
        return $this->showLogs($this->logFiles['debug']);
    }

    public function info()
    {
        return $this->showLogs($this->logFiles['info']);
    }

    public function warning()
    {
        return $this->showLogs($this->logFiles['warning']);
    }

    public function error()
    {
        return $this->showLogs($this->logFiles['error']);
    }

    public function critical()
    {
        return $this->showLogs($this->logFiles['critical']);
    }

    protected function showLogs($logFile)
    {
        $logFilePath = storage_path("logs/{$logFile}");

        if (File::exists($logFilePath)) {
            $logs = File::get($logFilePath);
        } else {
            $logs = 'Log file does not exist.';
        }

        return view('logs/index', compact('logs'));
    }
}
