<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth; 


class PatientController extends Controller
{
    use HttpResponses;
    
    // Show the patient
    public function index()
    {
        return PatientResource::collection
        (
            Patient::where('user_id', Auth::user()->id)->get()
        );
    }

    public function store(StorePatientRequest $request)
    {
        $request->validated($request->all());
        $patient = Patient::create(
            [
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'age' =>$request->age,
                'disease' =>$request->disease,
                'discreption' =>$request->discreption,
                'address' =>$request->address,
            ]); 
            return new PatientResource($patient);
    }
}
  