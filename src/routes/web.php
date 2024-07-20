<?php

use Illuminate\Support\Facades\Route;
use Shogy\LaravelLogDownloader\Http\Controllers\LogDownloadController;

Route::middleware(['web', 'auth'])->get('/download-logs', [LogDownloadController::class, 'downloadLogs']);
