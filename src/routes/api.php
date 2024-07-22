<?php

use Illuminate\Support\Facades\Route;
use Shogy\LaravelLogDownloader\Http\Controllers\LogDownloadController;

Route::middleware(['api', 'auth:api'])->get('/api/download-logs', [LogDownloadController::class, 'downloadLogs']);
