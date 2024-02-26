<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmergencyContactsRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\EmergencyContacts;
use App\Http\Resources\EmergencyContactsResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmergencyContactsController extends Controller
{
    use HttpResponses;
    // Get all Emergency Contacts
    public function index()
    {
        return EmergencyContactsResource::collection
        (
            EmergencyContacts::where('user_id', Auth::user()->id)->get()
        );
    }

    // Store a new Emergency Contact
    public function store(StoreEmergencyContactsRequest $request)
    {
        $request->validated($request->all());
        $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();

        $emergency = EmergencyContacts::create(
            [
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'image' =>$imageName,
                'contact' =>$request->contact
            ]);
            // save the image in storage folder
            Storage::disk('public')->put($imageName, file_get_contents($request->image));
            
            return new EmergencyContactsResource($emergency);
    }

   // Get a Single Emergency Contact
    public function show(EmergencyContacts $emergency)
    {
        if(Auth::user()->id !== $emergency->user_id ){
            return $this->error('','You are not allowed to make this request', 405);
        }
        return new EmergencyContactsResource($emergency);
    }

    // Update An Emergency Contact
    public function update(Request $request, EmergencyContacts $emergency)
    {
        if(Auth::user()->id !== $emergency->user_id){
            return $this->error("",'You are not authorized to make this request',404);
        }
    
        $emergency->update($request->all());
        return new EmergencyContactsResource($emergency);
    }

    // Delete An Emergency Contact
    public function destroy(EmergencyContacts $emergency)
    {
        if(Auth::user()->id !== $emergency->user_id){
            return $this->error("",'You are not authorized to make this request',404);
        }
        $emergency->delete();
        return response("The Emergency Contact has been deleted");
    }
}
