<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LogViewerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('posts', PostController::class)
    ->only(['index', 'store', 'show', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('comments', CommentController::class)
    ->only(['index', 'store', 'show', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

    Route::get('/logs', [LogViewerController::class, 'index'])->name('logs.index');
    Route::get('/logs/debug', [LogViewerController::class, 'debug'])->name('logs.debug');
    Route::get('/logs/info', [LogViewerController::class, 'info'])->name('logs.info');
    Route::get('/logs/warning', [LogViewerController::class, 'warning'])->name('logs.warning');
    Route::get('/logs/error', [LogViewerController::class, 'error'])->name('logs.error');
    Route::get('/logs/critical', [LogViewerController::class, 'critical'])->name('logs.critical');


require __DIR__ . '/auth.php';
