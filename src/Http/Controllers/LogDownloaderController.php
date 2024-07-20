<?php

namespace Shogy\LaravelLogDownloader\Http\Controllers;

use App\Helpers\InstanceHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class LogDownloadController extends Controller
{
    public function downloadLogs(): BinaryFileResponse|JsonResponse
    {
        $roles = Role::query();
        if (! auth()->user()->hasRole('superadmin')) {
            $roles->where('name', '!=', 'superadmin');
            if (! auth()->user()->hasRole('admin')) {
                $roles->where('name', '!=', 'admin');
            }
        }

        $instanceName = InstanceHelper::getInstanceName();
        $timestamp = Carbon::now()->format('Y_m_d_H:i:s');
        $fileName = $timestamp . '_' . $instanceName . '_logs.zip';
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
