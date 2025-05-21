<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrganizerController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\EventAddressController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\ParticipantController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::apiResource('organizers', OrganizerController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('event-addresses', EventAddressController::class);
Route::apiResource('registrations', RegistrationController::class);
Route::apiResource('participants', ParticipantController::class);