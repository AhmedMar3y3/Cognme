<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmergencyContactsController;
use App\Http\Controllers\FlaskController;
use App\Http\Controllers\GasSensorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PhysicianController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\WardrobeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//public routes
Route::post('/register',[AuthController::class , 'register']);
Route::post('/login',[AuthController::class , 'login']);
//socialite auth
//google
Route::get('/socialite/auth/google',[SocialiteController::class, 'redirectToGoogle']);
Route::get('/socialite/redirect/google',[SocialiteController::class, 'handleCallback']);
//facebook
Route::get('/socialite/auth/facebook',[SocialiteController::class, 'redirectToFacebook']);
Route::get('/socialite/redirect/facebook',[SocialiteController::class, 'Callback']);
Route::post('/forgetpassword', [AuthController::class, 'ForgetPass']);   
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/resetPassword', [AuthController::class, 'resetPassword']);
//private routes
Route::group(['middleware' => ['auth:sanctum']], function()
{   
 Route::resource('/patient', PatientController::class);
 Route::get('/wardrobe', [WardrobeController::class, 'index']);
 Route::resource('/emergency', EmergencyContactsController::class);
 Route::resource('/appointment', AppointmentController::class);
 Route::resource('/physician', PhysicianController::class);
 Route::post('/profile/update', [AuthController::class, 'updateUserProfile']);
 Route::post('/logout', [AuthController::class , 'logout']); 
 Route::get('/generate-qr-code-data', [QRCodeController::class, 'generateQrCodeForPatient']);

});


Route::post('/predict', [FlaskController::class, 'handlePrediction']);


//simulateion of the gas sensor 
Route::get('/simulateGasSensor', [GasSensorController::class,'simulateData']);
