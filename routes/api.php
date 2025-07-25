<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LoginSettingController;
use App\Http\Controllers\SystemSettingController;


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
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/company-settings', [CompanySettingController::class, 'show']);
    Route::post('/company-settings', [CompanySettingController::class, 'update']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('notifications', NotificationController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    // routes/api.php
    Route::get('/notification-recipients', [NotificationController::class, 'getRecipients']);

    // routes/api.php
    Route::post('/notifications/send', [NotificationController::class, 'sendNotification']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/login-settings', [LoginSettingController::class, 'index']);
    Route::post('/login-settings', [LoginSettingController::class, 'update']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/system-settings', [SystemSettingController::class, 'index']);
    Route::post('/system-settings', [SystemSettingController::class, 'update']);
});

