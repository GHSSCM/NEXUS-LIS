<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MigrationController extends Controller
{
    public function runMigrations()
    {
        // Ensure this endpoint is secured or only used in a controlled environment
        // Consider adding authentication/authorization checks here

        try {
            // Run the migrations
            Artisan::call('migrate', [
                '--force' => true, // Force the operation to run when in production.
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Migrations ran successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to run migrations: ' . $e->getMessage()
            ], 500);
        }
    }
}
