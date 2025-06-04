<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checkin;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    public function index()
    {
        return Checkin::all();
    }

    public function getByRegistration($registrationId)
    {
        $checkins = Checkin::with(['registration.participant', 'registration.event'])
            ->where('registration_id', $registrationId)
            ->get();

        return $checkins;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
        ]);

        return Checkin::create($validated);
    }

    public function show(Checkin $checkin)
    {
        return $checkin;
    }

    public function update(Request $request, Checkin $checkin)
    {
        $validated = $request->validate([
            'registration_id' => 'sometimes|exists:registrations,id',

        ]);

        $checkin->update($validated);

        return $checkin;
    }

    public function destroy(Checkin $checkin)
    {
        $checkin->delete();

        return response()->noContent();
    }
}