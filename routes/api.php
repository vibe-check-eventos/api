<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrganizerController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\EventAddressController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\ParticipantController;
use App\Http\Controllers\Api\CheckinController;
use App\Http\Controllers\Api\QrCodeController;

Route::apiResource('organizers', OrganizerController::class);
Route::post('organizers/login', [OrganizerController::class, 'login']);

Route::apiResource('events', EventController::class);
Route::get('organizers/{organizer_id}/events', [EventController::class, 'eventsByOrganizer']);

Route::apiResource('event-addresses', EventAddressController::class);

Route::apiResource('registrations', RegistrationController::class);
Route::get('registrations/{event_id}/event', [RegistrationController::class, 'registrationsByEvent']);

Route::apiResource('participants', ParticipantController::class);
Route::post('participants/login', [ParticipantController::class, 'login']);
Route::get('participants/{participant_id}/registrations', [RegistrationController::class, 'registrationsByParticipant']);

Route::apiResource('checkins', CheckinController::class);
Route::get('checkins/{registration_id}/registration', [CheckinController::class, 'getByRegistration']);

Route::apiResource('qrcode', QrCodeController::class);
Route::get('qrcode/{participant_id}/participant', [QrCodeController::class, 'getByParticipant']);
