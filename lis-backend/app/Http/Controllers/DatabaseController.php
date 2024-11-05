<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

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

    


    function emptyDatabase()
    {
        $tables = DB::select('SHOW TABLES');
        $tableKey = 'Tables_in_' . env('DB_DATABASE');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($tables as $table) {
            DB::table($table->$tableKey)->truncate();
            DB::statement("DROP TABLE {$table->$tableKey}");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
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


        $isCompiledVersion =  !empty(env("COMPILED_VERSION"));
        $storageDirectory = $isCompiledVersion? storage_path('app/imports'): storage_path('app\\imports');
        if(!file_exists($storageDirectory)){
            mkdir($storageDirectory, 0777, true);
        }


        $filepath = $file->storeAs('imports', now().'_'. $file->getClientOriginalName());

        // dd($filepath);


        // DB::statement("DROP DATABASE IF EXISTS `$databaseName`");
        // DB::statement("CREATE DATABASE IF NOT EXISTS `$databaseName`");


        $path = !$isCompiledVersion? storage_path('app/' . $filepath): (storage_path('app\\'.str_replace("/","\\",$filepath)));


        // echo $path;
        $content  = file_get_contents($path);
        // echo $content;

        $this->emptyDatabase();

        


        $content="USE `$databaseName`; ".$content;
        DB::unprepared($content);

        die("<div style='padding:40px;'><h1>Imported successfully. Please wait. Redirecting to login... </h1><script> window.localStorage.clear();setTimeout(function(){window.location='/login'},3000)</script></div>");


        return;


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

    /*   public function importDatabase(Request $request)
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
    } */
}
