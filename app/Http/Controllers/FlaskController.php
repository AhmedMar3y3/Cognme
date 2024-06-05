<?php

namespace App\Http\Controllers;

use App\Services\FlaskService;
use Illuminate\Http\Request;

class FlaskController extends Controller
{
    protected $flaskService;

    public function __construct(FlaskService $flaskService)
    {
        $this->flaskService = $flaskService;
    }

    public function handlePrediction(Request $request)
    {
        $texts = $request->input('texts');
        $predictions = $this->flaskService->predict($texts);

        return response()->json($predictions);
    }
}
