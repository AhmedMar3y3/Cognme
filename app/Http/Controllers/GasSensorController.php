<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GasSensorController extends Controller
{
    public function simulateData()
    {
        $gasLevel = rand(1, 100);
        $gasThreshold = 50;
        $gasDetected = $gasLevel > $gasThreshold;
        return response()->json(['gas_detected' => $gasDetected]);
    }

}
