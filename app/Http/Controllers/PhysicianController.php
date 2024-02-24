<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhysicianRequest;
use App\Http\Resources\PhysicianResource;
use App\Models\Physician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhysicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhysicianRequest $request)
    {
        $request->validated($request->all());

        $physician = Physician::create(
            [
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'email' =>$request->email,
                'specialization' =>$request->specialization,
                'contact' =>$request->contact
            ]);
            return new PhysicianResource($physician);
    }


    public function show(Physician $physician)
    {
        if(Auth::user()->id !== $physician->user_id ){
            return $this->error('','You are not allowed to make this request', 405);
        }
        return new PhysicianResource($physician);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
