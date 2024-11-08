<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('backup.index');
    }

    public function export()
    {
        $sourcePath = database_path(env('DB_DATABASE', 'database.sqlite'));
        $backupPath = public_path('backups/database_backup.sqlite');

        if (File::copy($sourcePath, $backupPath)) {
            return response()->download($backupPath)->deleteFileAfterSend(false);
        } else {
            return redirect()->back()->with('error', 'Failed to create database backup.');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');

        $tempPath = $file->getPathname();
        $destinationPath = database_path(env('DB_DATABASE', 'database.sqlite'));

        if (File::copy($tempPath, $destinationPath)) {
            return redirect()->back()->with('success', 'Database imported successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to import database.');
        }
    }
}
