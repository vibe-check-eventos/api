<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $participants = Participant::all(); // Or Participant::with('registrations')->get(); if relationship exists

        return response()->json($participants);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:participants',
            'password' => 'required|string|min:8',
        ]);

        $participant = Participant::create($request->all()); // Use validated data here
        return response()->json($participant, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $participant = Participant::find($id); // Or Participant::with('registrations')->find($id);

        if (!$participant) {
            return response()->json(['message' => 'Participant not found'], 404);
        }
        return response()->json($participant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $participant = Participant::find($id);

        if (!$participant) {
            return response()->json(['message' => 'Participant not found'], 404);
        }

        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:participants',
            'password' => 'required|string|min:8',
        ]);

        $participant->update($request->all()); // Use validated data here
        return response()->json($participant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $participant = Participant::find($id);

        if (!$participant) {
            return response()->json(['message' => 'Participant not found'], 404);
        }

        $participant->delete();
        return response()->json(['message' => 'Participant deleted successfully']);
    }
}
