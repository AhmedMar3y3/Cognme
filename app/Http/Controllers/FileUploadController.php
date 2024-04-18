<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function uploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('files', 'public');
            $url = Storage::disk('public')->url($path);

            return response()->json(['message' => 'File uploaded successfully', 'path' => $path, 'url' => $url]);
        }

        return response()->json(['message' => 'No file uploaded']);
    
    }
}
