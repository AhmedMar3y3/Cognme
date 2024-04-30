<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WardrobeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $patients = Patient::where('user_id', $user->id)->get();
        $photoUrls = [];

        foreach ($patients as $patient) {
            $paths = json_decode($patient->photo_paths, true); // Decode JSON string into an array
            if (is_array($paths)) {
                foreach ($paths as $path) {
                    $photoUrls[] = Storage::disk('public')->url($path);
                }
            } else {
                Log::error('Expected an array for photo_paths but received a different type', ['received_type' => gettype($paths)]);
            }
        }

        // Log the photo URLs for debugging
        Log::info('Photos found:', ['photos' => $photoUrls]);

        return response()->json(['photos' => $photoUrls]);
    }

    
}
