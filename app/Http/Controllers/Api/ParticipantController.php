<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Validation\ValidationException;
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
     * Login a participant.
     */
    public function login(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Dados inválidos.',
                'missing' => $e->errors()
            ], 422);
        }

        $participant = Participant::where('email', $request->email)->first();

        if (!$participant || $participant->password !== $request->password) {
            return response()->json(['message' => 'Credenciais inválidas.'], 401);
        }

        // In a real app, return a token here
        return response()->json(['message' => 'Login realizado com sucesso.', 'participant' => $participant]);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            // Validate the request data
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:participants',
                'password' => 'required|string|min:8',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Dados inválidos.',
                'missing' => $e->errors()
            ], 422);
        }

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
            return response()->json(['message' => 'Participante não encontrado.'], 404);
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
            return response()->json(['message' => 'Participante não encontrado.'], 404);
        }

            try {
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Dados inválidos.',
                'missing' => $e->errors()
            ], 422);
        }

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
            return response()->json(['message' => 'Participante não encontrado.'], 404);
        }

        $participant->delete();
        return response()->json(['message' => 'Participante deletado com sucesso.']);
    }
}
