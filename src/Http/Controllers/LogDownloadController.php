<?php

namespace Shogy\LaravelLogDownloader\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class LogDownloadController extends BaseController
{
    public function downloadLogs(): BinaryFileResponse|JsonResponse
    {
        $logsPath = base_path('storage/logs'); // Base path to the logs directory
        $timestamp = Carbon::now()->format('Y_m_d_H_i_s');
        $fileName = $timestamp . '_logs.zip';
        $zipPath = base_path($fileName); // Path where the ZIP file will be stored

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // Get all files in the logs directory
            $files = glob($logsPath . '/*'); // List files in the directory

            foreach ($files as $file) {
                if (is_file($file)) {
                    $relativeName = basename($file); // Get the file name
                    $zip->addFile($file, $relativeName); // Add file to the ZIP
                }
            }

            $zip->close();
        } else {
            return response()->json(['error' => 'Unable to create ZIP file'], 500);
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
