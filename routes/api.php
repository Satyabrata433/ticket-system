<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\EmployeeController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/home',function(){
    return "wel come";
});

Route::post('/request-otp', [AuthController::class, 'requestOtp'])->name('request.otp');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/roles', RoleController::class);  
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/partners', PartnerController::class);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/employees', EmployeeController::class);
});

