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

        $isCompiledVersion =  !empty(env("COMPILED_VERSION"));
        $mysqldumpPath = $isCompiledVersion?"C:\\xampp\\mysql\\bin\\mysqldump":"mysqldump";

        $command = "$mysqldumpPath --user={$username} ".(!empty($password)?"--password={$password}":"")." --host={$host} {$databaseName} > {$filepath}";
       
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
        
        
      
        // $request->validate([
        //     'sql_file' => 'required|mimes:sql|max:10000'
        // ], [
        //     'sql_file.required' => 'Please upload an SQL file.',
        //     'sql_file.mimes' => 'Only SQL files are allowed.',
        //     'sql_file.max' => 'The uploaded file must not exceed 10MB.'
        // ]);

        
        $databaseName = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        
        $file = $request->file('sql_file');



        $filepath = $file->storeAs('imports', $file->getClientOriginalName());


        $isCompiledVersion =  !empty(env("COMPILED_VERSION"));
        $mysqlPath = $isCompiledVersion?"C:\\xampp\\mysql\\bin\\mysql":"mysql";

        $command = "$mysqlPath --user={$username} ".(!empty($password)?"--password={$password}":"")." --host={$host} {$databaseName} -e \"DROP DATABASE IF EXISTS {$databaseName}; CREATE DATABASE {$databaseName};\"" ;
        $process = Process::fromShellCommandline($command);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            return response()->json(['error' => 'Database import failed[1]: ' . $exception->getMessage()], 500);
        }




        $command = "$mysqlPath --user={$username} ".(!empty($password)?"--password={$password}":"")." --host={$host} {$databaseName} < " . storage_path('app/' . $filepath);
        $process = Process::fromShellCommandline($command);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            return response()->json(['error' => 'Database import failed[2]: ' . $exception->getMessage()], 500);
        }

        die("<div style='padding:40px;'><h1>Imported successfully. Please wait. Redirecting to login... </h1><script>setTimeout(function(){window.location='/login'},3000)</script></div>");
    }
}
