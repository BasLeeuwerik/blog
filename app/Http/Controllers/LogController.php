<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use App\Services\LoggingServiceInterface;
use Illuminate\Http\Request;

class LogController extends Controller
{
    protected $logFiles = [
        'info' => 'info.log',
        'error' => 'laravel.log', // Error logs are in laravel.log
        'email' => 'email.log',
    ];

    protected $loggingService;

    public function __construct(LoggingServiceInterface $loggingService)
    {
        $this->loggingService = $loggingService;
    }

    /**
     * Log a message of a given level.
     *
     * @param string $level
     * @return \Illuminate\Http\JsonResponse
     */
    public function log(string $level)
    {
        $message = ucfirst($level) . ' log added';
        $this->loggingService->log($level, $message);

        return response()->json(['status' => 'success', 'message' => $message]);
    }

    /**
     * Display the latest log entries.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return $this->showLogs('laravel.log', 'Index', $request);
    }

    /**
     * Display logs by type.
     *
     * @param string $type
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function show(string $type, Request $request)
    {
        $fileName = $this->logFiles[$type] ?? 'laravel.log';
        $onlyErrors = $type === 'error';

        return $this->showLogs($fileName, ucfirst($type), $request, $onlyErrors);
    }

    /**
     * Display the log entries.
     *
     * @param string $fileName
     * @param string $logType
     * @param Request $request
     * @param bool $onlyErrors
     * @return \Illuminate\View\View
     */
    protected function showLogs($fileName, $logType, Request $request, $onlyErrors = false)
    {
        $logFilePath = storage_path("logs/{$fileName}");
        $linesPerPage = 100;
        $page = $request->query('page', 1);

        $logData = $this->tailFile($logFilePath, $linesPerPage * $page);
        $logLines = $logData['logLines'];
        $totalLines = $logData['totalLines'];

        if ($onlyErrors) {
            $logLines = array_filter($logLines, function ($line) {
                return strpos($line, 'local.ERROR') !== false;
            });
        }

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
        if (!File::exists($filePath)) {
            return ['logLines' => [], 'totalLines' => 0];
        }

        $f = fopen($filePath, "r");
        $buffer = 4096;
        $totalLines = 0;
        $linesRead = 0;

        // Read file to count total lines
        while (!feof($f)) {
            fgets($f);
            $totalLines++;
        }

        fseek($f, 0, SEEK_END);
        $data = '';

        while (ftell($f) > 0 && $linesRead < $lines) {
            $pos = max(-$buffer, -ftell($f));
            fseek($f, $pos, SEEK_CUR);
            $chunk = fread($f, $buffer);
            $data = $chunk . $data;
            fseek($f, $pos, SEEK_CUR);

            $linesRead += substr_count($chunk, "\n");
        }

        fclose($f);

        $logLines = array_slice(explode("\n", $data), -$lines);

        return [
            'logLines' => $logLines,
            'totalLines' => $totalLines,
        ];
    }
}
