<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    use HttpResponses;
    // Get all Appointments
    public function index()
    {
        
        return AppointmentResource::collection
        (
            Appointment::where('user_id', Auth::user()->id)->get()
          
        );
    }

   // Create a new Appointment
   
    public function store(StoreAppointmentRequest $request)
    {
        $request->validated($request->all());
        $appointment = Appointment::create(
            [
                'user_id' => Auth::user()->id,
                'discreption' => $request->discreption,
                'appointment_date' =>$request->appointment_date
            ]); 
            return new AppointmentResource($appointment);
    }

   // Show a single Appointment
    public function show(Appointment $appointment)
    {
        if(Auth::user()->id !== $appointment->user_id ){
            return $this->error('','You are not allowed to make this request', 405);
        }
        return new AppointmentResource($appointment);
    }

  
  // Delete an Appointment
    public function destroy(Appointment $appointment)
    {
        if(Auth::user()->id !== $appointment->user_id){
            return $this->error("",'You are not authorized to make this request',404);
        }
        $appointment->delete();
        return response("The Appointment has been deleted");
    }
}
