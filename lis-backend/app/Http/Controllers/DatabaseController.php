<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DatabaseController extends Controller
{
    public function exportDatabase()
    {
        $databaseName = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = storage_path('app/' . $filename);

        $command = "C:\\xampp\\mysql\\bin\\mysqldump --user={$username} --password={$password} --host={$host} {$databaseName} > {$filepath}";
       
        shell_exec($command);
        ///
        // // $process = Process::fromShellCommandline($command);

        // try {
        //     $process->mustRun();
        // } catch (ProcessFailedException $exception) {
        //     return response()->json(['error' => 'Database export failed: ' . $exception->getMessage()], 500);
        // }

        return response()->download($filepath)->deleteFileAfterSend(true);
    }

    public function importDatabase(Request $request)
    {
        $request->validate([
            'sql_file' => 'required|file|mimes:sql',
        ]);

        $databaseName = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        
        $file = $request->file('sql_file');
        $filepath = $file->storeAs('imports', $file->getClientOriginalName());

        // if(request()->url())
        $command = "C:\\xampp\\mysql\\bin\\mysql --user={$username} --password={$password} --host={$host} {$databaseName} < " . storage_path('app/' . $filepath);
        $process = Process::fromShellCommandline($command);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            return response()->json(['error' => 'Database import failed: ' . $exception->getMessage()], 500);
        }

        return response()->json(['message' => 'Database imported successfully.']);
    }
}
