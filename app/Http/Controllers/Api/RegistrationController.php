<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrations = Registration::all();
        return response()->json($registrations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
        $request->validate([
            'participant_id' => 'required|integer',
            'event_id' => 'required|integer',
            'qr_code_base64' => 'required|string'
        ]);

        $registration = new Registration;
        $registration->participant_id = $request->participant_id;
        $registration->event_id = $request->event_id;
        $registration->qr_code_base64 = $request->qr_code_base64;

        $registration->save();

        return response()->json($registration, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
        $registration = Registration::find($id);

        if (!$registration) {
            return response()->json(['message' => 'Registration not found'], 404);
        }

        return response()->json($registration);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   

        $request->validate([
            'participant_id' => 'required|integer',
            'event_id' => 'required|integer',
            'qr_code_base64' => 'required|string'
        ]);

        $registration = Registration::find($id);

        if (!$registration) {
            return response()->json(['message' => 'Registration not found'], 404);
        }

        $registration->participant_id = $request->participant_id;
        $registration->event_id = $request->event_id;
        $registration->qr_code_base64 = $request->qr_code_base64;

        $registration->save();

        return response()->json($registration);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
        $registration = Registration::find($id);

        if (!$registration) {
            return response()->json(['message' => 'Registration not found'], 404);
        }

        $registration->delete();

        return response()->json(['message' => 'Registration deleted successfully']);
    }
}
