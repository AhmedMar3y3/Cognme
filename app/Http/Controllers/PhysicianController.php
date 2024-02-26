<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhysicianRequest;
use App\Http\Resources\PhysicianResource;
use App\Models\Physician;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhysicianController extends Controller
{
    use HttpResponses;

   // Get all Physicians
    public function index()
    {
        return PhysicianResource::collection
        (
            Physician::where('user_id', Auth::user()->id)->get()
        );
    }
   
    // Store a new Physician
    public function store(StorePhysicianRequest $request)
    {
        $request->validated($request->all());

        $physician = Physician::create(
            [
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'email' =>$request->email,
                'address' => $request->address,
                'specialization' =>$request->specialization,
                'contact' =>$request->contact
            ]);
            return new PhysicianResource($physician);
    }

    // Get a single Physician
    public function show(Physician $physician)
    {
        if(Auth::user()->id !== $physician->user_id ){
            return $this->error('','You are not allowed to make this request', 405);
        }
        return new PhysicianResource($physician);
    }
}
