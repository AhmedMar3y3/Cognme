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
        return PatientResource::collection(
            Patient::where('user_id', Auth::user()->id)->get()
        );
    }

    public function store(StorePatientRequest $request)
    {
        $request->validated();
        $patient = new Patient([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'medical_history' => $request->medical_history,
            'address' => $request->address,
        ]);
        if ($request->hasFile('photos')) {
            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('patients', 'public');
                $photoPaths[] = $path;
            }
            $patient->photo_paths = json_encode($photoPaths);
        }
        $patient->save();
        return new PatientResource($patient);
    }
}
  