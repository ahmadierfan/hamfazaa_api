<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MVerificationcodeController;
use App\Http\Controllers\SRoomeventController;
use App\Http\Controllers\MRoomController;
use App\Http\Controllers\ZarinpalController;
use App\Http\Controllers\MOrderController;
use App\Http\Controllers\BPlanController;


Route::post('/pay', [MOrderController::class, 'create']);
Route::get('/callback', [ZarinpalController::class, 'callback']);
Route::get('/plans', [BPlanController::class, 'index']);

Route::middleware(['auth:api'])->group(function () {
    //order
    Route::get('plan-detail', [BPlanController::class, 'show']);
    Route::get('order-detail', [MOrderController::class, 'showForTransaction']);

    //users 
    Route::get('company-users', [UserController::class, 'forCompany']);
    Route::post('company-create-update-user', [UserController::class, 'createUpdate']);
    Route::post('company-delete-user', [UserController::class, 'delete']);


    //room
    Route::get('company-active-rooms', [MRoomController::class, 'activeRomms']);
    Route::get('company-rooms', [MRoomController::class, 'forCompany']);
    Route::post('company-create-update-room', [MRoomController::class, 'createUpdate']);
    Route::post('company-delete-room', [MRoomController::class, 'delete']);

    //events
    Route::get('company-rooms-requirement', [SRoomeventController::class, 'eventRequirement']);

    Route::get('company-room-events', [SRoomeventController::class, 'forCompany']);
    Route::post('company-create-update-event', [SRoomeventController::class, 'companyCreateUpdate']);
    Route::post('company-delete-event', [SRoomeventController::class, 'comapnyDelete']);

    Route::post('user-create-update-event', [SRoomeventController::class, 'userCreateUpdate']);
    Route::post('user-delete-event', [SRoomeventController::class, 'userDelete']);

    //auth
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', function () {
        auth()->logout();
    });
});

Route::prefix('auth')->group(function () {
    Route::post('company-otp-register', [MVerificationcodeController::class, 'companyOtpRegister']);
    Route::post('company-otp-register-verify', [MVerificationcodeController::class, 'companyRegisterVerify']);
    Route::post('company-login', [MVerificationcodeController::class, 'companyLogin']);

    Route::post('user-otp', [MVerificationcodeController::class, 'userOtp']);
    Route::post('user-verify-otp', [MVerificationcodeController::class, 'userVerifyOtp']);
});


