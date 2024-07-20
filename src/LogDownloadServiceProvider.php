<?php

namespace Shogy\LaravelLogDownloader;

use Illuminate\Support\ServiceProvider;

class LogDownloaderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Publish config file if needed
        $this->publishes([
            __DIR__.'/config/logdownloader.php' => config_path('logdownloader.php'),
        ]);
    }

    public function register()
    {
        // Register the controller
        $this->app->make('Shogy\LogDownloader\Http\Controllers\LogDownloadController');
    }
}
