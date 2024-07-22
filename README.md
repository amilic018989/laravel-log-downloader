# Laravel Log Downloader

![Latest Stable Version](https://img.shields.io/packagist/v/shogy/laravel-log-downloader?label=stable)
[![Total Downloads](https://poser.pugx.org/shogy/laravel-log-downloader/downloads)](https://packagist.org/packages/shogy/laravel-log-downloader)
[![License](https://poser.pugx.org/shogy/laravel-log-downloader/license)](https://packagist.org/packages/shogy/laravel-log-downloader)

Laravel Log Downloader is a package that allows you to easily download all log files from your Laravel project as a ZIP archive. This package provides both web and API routes for flexibility.

## Features

- Download all log files as a ZIP archive.
- Supports both web and API routes.
- Automatically deletes the ZIP file after download.
- Compatible with Laravel 11.x.

## Installation

You can install the package via Composer:

```bash
composer require shogy/laravel-log-downloader

```

## Configuration

After installing the package, the service provider will be automatically registered. If you need to register it manually, add the following line to your config/app.php file:

```bach
'providers' => [
    // Other Service Providers

    Shogy\LaravelLogDownloader\LogDownloaderServiceProvider::class,
],
```
# Usage

## Web route

To download logs via a web route, navigate to the following URL in your browser:

```bash
http://your-app-url/download-logs
```

## Api route

To download logs via an API route, send a GET request to:

```bash
http://your-app-url/api/download-logs
```

Make sure to include the necessary API authentication if your API routes are protected.

## Route middleware

By default, the web route uses the web and auth middleware, while the API route uses the api and auth:api middleware. You can customize the middleware as needed.

```bash
// Web route
Route::middleware(['web', 'auth'])->get('/download-logs', [LogDownloadController::class, 'downloadLogs']);

// Api route
Route::middleware(['api', 'auth:api'])->get('/api/download-logs', [LogDownloadController::class, 'downloadLogs']);
```

## Contributions

Contributions are welcome!
If you encounter any issues or have questions, feel free to open an issue on GitHub.

