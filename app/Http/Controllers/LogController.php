<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class LogController extends Controller
{
    protected $logFiles = [
        'info' => 'info.log',
        'error' => 'laravel.log',
        'email' => 'email.log',
    ];

    /**
     * Display the latest log entries.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return $this->showLogs('laravel.log', 'Index', false);
    }

    /**
     * Display logs by type.
     *
     * @param string $type
     * @return \Illuminate\View\View
     */
    public function show(string $type, Request $request)
    {
        $fileName = $this->logFiles[$type] ?? 'laravel.log';
        $logType = ucfirst($type);
        $onlyErrors = ($type === 'error');

        return $this->showLogs($fileName, $logType, $onlyErrors);
    }

    /**
     * Display the log entries.
     *
     * @param string $fileName
     * @param string $logType
     * @param bool $onlyErrors
     * @return \Illuminate\View\View
     */
    protected function showLogs($fileName, $logType = 'Index', $onlyErrors = false)
    {
        $logFile = storage_path("logs/{$fileName}");
        $linesPerPage = 100;
        $page = request('page', 1);

        // Check if file exists
        if (!File::exists($logFile)) {
            return view('logs.index', [
                'logLines' => ['Log file does not exist.'],
                'logType' => $logType,
                'totalLines' => 0,
                'linesPerPage' => $linesPerPage,
                'currentPage' => $page,
            ]);
        }

        $logData = $this->tailFile($logFile, $linesPerPage * $page);
        $logLines = $logData['logLines'];
        $totalLines = $logData['totalLines'];

        // Filter logs based on type
        if ($onlyErrors) {
            $logLines = array_filter($logLines, function ($line) {
                return strpos($line, 'local.ERROR') !== false;
            });
        } else {
            $logLines = array_filter($logLines, function ($line) {
                return strpos($line, 'local.ERROR') === false;
            });
        }

        // Paginate filtered logs
        $logLines = array_slice($logLines, -$linesPerPage);

        return view('logs.index', [
            'logLines' => $logLines,
            'logType' => $logType,
            'totalLines' => $totalLines,
            'linesPerPage' => $linesPerPage,
            'currentPage' => $page,
        ]);
    }

    /**
     * Get the last few lines of a file.
     *
     * @param string $filePath
     * @param int $lines
     * @return array
     */
    private function tailFile($filePath, $lines = 100)
    {
        $f = fopen($filePath, "r");
        $buffer = 4096;
        $totalLines = 0;
        $data = '';

        // Read file from end to start
        if (flock($f, LOCK_SH)) {
            fseek($f, 0, SEEK_END);
            $filesize = ftell($f);
            $offset = max(0, $filesize - ($buffer * 2)); // Ensure we don't go beyond file start

            while ($filesize - $offset > 0 && $totalLines < $lines) {
                fseek($f, $offset);
                $chunk = fread($f, $buffer);
                $data = $chunk . $data;
                $offset = max(0, $offset - $buffer);
                $totalLines += substr_count($chunk, "\n");
            }
            flock($f, LOCK_UN);
        }
        fclose($f);

        // Return the last few lines
        $logLines = array_slice(explode("\n", $data), -$lines);
        return [
            'logLines' => $logLines,
            'totalLines' => $totalLines,
        ];
    }
}
