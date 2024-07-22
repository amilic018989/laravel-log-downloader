<?php

namespace Shogy\LaravelLogDownloader;

use Illuminate\Support\ServiceProvider;

class LogDownloaderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load web routes
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        // Load API routes
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');

        // Publish config file if needed
        $this->publishes([
            __DIR__.'/config/logdownloader.php' => config_path('logdownloader.php'),
        ]);
    }

    public function register()
    {
        // Register the controller
        $this->app->make('Shogy\LaravelLogDownloader\Http\Controllers\LogDownloadController');
    }
}
