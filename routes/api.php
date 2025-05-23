<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrganizerController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\EventAddressController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\ParticipantController;

Route::apiResource('organizers', OrganizerController::class);
Route::post('organizers/login', [OrganizerController::class, 'login']);

Route::apiResource('events', EventController::class);
Route::get('organizers/{organizer_id}/events', [EventController::class, 'eventsByOrganizer']);

Route::apiResource('event-addresses', EventAddressController::class);

Route::apiResource('registrations', RegistrationController::class);
Route::get('participants/{participant_id}/registrations', [RegistrationController::class, 'registrationsByParticipant']);

Route::apiResource('participants', ParticipantController::class);
Route::post('participants/login', [ParticipantController::class, 'login']);