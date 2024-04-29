<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
//     public function generateQrCodeForPatient()
// {
//     // Retrieve authenticated user
//     $user = Auth::user();

//     // Ensure user has a patient record
//     if (!$user->patient) {
//         return response()->json(['error' => 'User does not have a patient record'], 404);
//     }

//     // Retrieve patient associated with the user
//     $patient = $user->patient;

//     // Patient data to be encoded into the QR code
//     $patientData = [
//         'name' => $patient->name,
//         'phone' => $user->phone,
//         'medical_history' => $patient->medical_history,
//         'address' => $patient->address,
//     ];

//     // Encode patient data into JSON format
//     $encodedData = json_encode($patientData);

//     // Generate QR code using the encoded data
//     $qrCode = QrCode::format('png')->size(200)->generate($encodedData); // Ensure format is set to png and size is specified

//     // Return the QR code image
//     return response($qrCode)->header('Content-Type', 'image/png');
// }
public function generateQrCodeForPatient()
{
    // Retrieve authenticated user (patient's assistant)
    $user = Auth::user();

    // Retrieve patient associated with the user
    $patient = $user->patient;

    // Prepare patient data
    $patientData = [
        'name' => $patient->name,
        'phone' => $user->phone, // Assuming user's phone is the patient's phone
        'medical_history' => $patient->medical_history,
        'address' => $patient->address,
    ];

    // Return patient data
    return response()->json($patientData);
}
}
