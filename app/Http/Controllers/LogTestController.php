<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class LogTestController extends Controller
{
    public function generateLogs()
    {
        Log::debug('This is a debug message.');
        Log::info('This is an info message.');
        Log::notice('This is a notice message.');
        Log::warning('This is a warning message.');
        Log::error('This is an error message.');
        Log::critical('This is a critical message.');
        Log::alert('This is an alert message.');
        Log::emergency('This is an emergency message.');

        return view('dashboard');
    }
}
