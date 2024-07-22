<?php

namespace Shogy\LaravelLogDownloader\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class LogDownloadController extends BaseController
{
    public function downloadLogs(): BinaryFileResponse|JsonResponse
    {
        $timestamp = Carbon::now()->format('Y_m_d_H_i_s');
        $fileName = $timestamp . '_logs.zip';
        $zipPath = Storage::disk('local')->path($fileName);

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $files = Storage::disk('logs')->files();

            foreach ($files as $file) {
                $relativeName = basename($file);
                $zip->addFile(Storage::disk('logs')->path($file), $relativeName);
            }

            $zip->close();
        } else {
            return response()->json(['error' => 'Unable to create ZIP file'], 500);
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
