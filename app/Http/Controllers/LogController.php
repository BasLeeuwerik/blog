<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    /**
     * Display the logs filtered by type.
     *
     * @param  string  $type
     * @return \Illuminate\View\View
     */
    public function show($type)
    {
        $filePath = storage_path('logs/laravel.log');

        if (!File::exists($filePath)) {
            return redirect()->route('logs.index')->with('error', "Log file for '{$type}' does not exist.");
        }

        $logLines = $this->getFilteredLogs($filePath, $type);

        return view('logs.index', compact('logLines', 'type'));
    }

    /**
     * Get filtered log lines by type.
     *
     * @param  string  $filePath
     * @param  string  $type
     * @return array
     */
    private function getFilteredLogs($filePath, $type)
    {
        $logs = File::lines($filePath);
        $filteredLogs = [];

        foreach ($logs as $log) {
            if (stripos($log, strtoupper($type)) !== false) {
                $filteredLogs[] = $log;
            }
        }

        return $filteredLogs;
    }
}
