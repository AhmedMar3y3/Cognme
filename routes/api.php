<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmergencyContactsController;
use App\Http\Controllers\PhysicianController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//public routes
Route::post('/register',[AuthController::class , 'register']);
Route::post('/login',[AuthController::class , 'login']);
//private routes
Route::group(['middleware' => ['auth:sanctum']], function()
{   
 Route::resource('/emergency', EmergencyContactsController::class);
 Route::resource('/physician', PhysicianController::class);
 Route::post('/logout', [AuthController::class , 'logout']);
});
