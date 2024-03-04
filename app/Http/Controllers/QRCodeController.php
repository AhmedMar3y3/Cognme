<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    

public function generateQrCodeForPatient()
{
    // Retrieve authenticated user (patient's assistant)
    $user = Auth::user();

    // Retrieve patient associated with the user
    $patient = $user->patient;

    // Encode patient data into a string (e.g., JSON format)
    $patientData = [
        'id' => $patient->user_id,
        'name' => $patient->name,
        'age' => $patient->age,
        
    ];

    $encodedData = json_encode($patientData);

    // Generate QR code using the encoded data
    // (Use the QR code generation method from your previous implementation)
    return $this->generateQrCode($encodedData);
}

    
}
