<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    
    {  
        
        // Optionally check if the symlink exists and create it if not.
        $storageLink = public_path('storage');
        if (!file_exists($storageLink)) {
            Artisan::call('storage:link');
        }
    
        // Check if the file is present
        if ($request->hasFile('file')) {
            // Validate the image (optional)
            $request->validate([
                'file' => 'image|max:100048', // Max ~100MB
            ]);

            $file = $request->file('file');
            // Create a unique filename
            $filename = time() . '-' . $file->getClientOriginalName();
            // Save file to storage (public disk must be linked via "php artisan storage:link")
            $filePath = $file->storeAs('uploads', $filename, 'public');

            // Generate the URL to the stored file
            $url = asset('storage/' . $filePath);

            // Return a JSON response in the format TinyMCE expects
            return response()->json(['location' => $url]);
        }

        // Return an error response if no file was uploaded
        return response()->json(['error' => 'No file uploaded.'], 400);
    }
}
