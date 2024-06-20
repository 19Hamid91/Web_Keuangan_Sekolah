<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupController extends Controller
{
    public function index($instansi)
    {
        return view('backup.index');
    }
    public function run()
    {
        try {
            $backupFile = 'backup_' . date('Ymd_His') . '.sql';
            $backupPath = storage_path('app/backups') . '/' . $backupFile;
    
            if (!file_exists(dirname($backupPath))) {
                mkdir(dirname($backupPath), 0755, true);
            }
    
            $file = fopen($backupPath, 'w');
            if ($file === false) {
                throw new \Exception('Tidak dapat membuka atau membuat file backup');
            }
            $artisan = base_path('artisan');
            $process = new Process(['C:/xampp743/php/php.exe', $artisan, 'backup:run']);
            $process->setTimeout(3600); // Optional: Set timeout dalam detik (misalnya 1 jam)
            $process->run();
            
            // Periksa jika proses berhasil dijalankan
            if ($process->isSuccessful()) {
                dd($process->getOutput());
                // Tulis output dari proses ke file backup
                fwrite($file, $process->getOutput());
                fclose($file); // Tutup file setelah selesai menulis
    
                \Log::info('Backup berhasil: ' . $backupFile);
    
                return response()->json([
                    'status' => 'success',
                    'message' => 'Backup berhasil!',
                    'file' => $backupFile,
                ]);
            } else {
                // Tangani kesalahan jika proses gagal
                throw new ProcessFailedException($process);
            }
        } catch (\Exception $e) {
            \Log::error('Backup gagal: ' . $e->getMessage());
    
            return response()->json([
                'status' => 'error',
                'message' => 'Backup gagal: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function list()
    {
        try {
            $files = Storage::disk('backup')->files('Sistem-Informasi-Akuntansi-PAPB');

            $backupFiles = array_map(function ($file) {
                return [
                    'name' => basename($file),
                    'size' => round(Storage::disk('backup')->size($file) / 1048576, 2),
                    'download_url' => Storage::disk('backup')->url($file)
                ];
            }, $files);

            return response()->json([
                'status' => 'success',
                'files' => $backupFiles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to list backups: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $filename = $request->input('filename');

            if (Storage::disk('backup')->exists($filename)) {
                Storage::disk('backup')->delete($filename);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Backup deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File not found!'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete backup: ' . $e->getMessage()
            ], 500);
        }
    }
}