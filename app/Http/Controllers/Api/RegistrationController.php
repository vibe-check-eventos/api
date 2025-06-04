<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrations = Registration::with(['participant', 'event'])->get();
        return response()->json($registrations);
    }

    /**
     * Display a listing of registrations for a specific event with relationships.
     */
    public function registrationsByEvent($event_id)
    {
        $registrations = Registration::with(['participant', 'event'])
            ->where('event_id', $event_id)
            ->get();

        if ($registrations->isEmpty()) {
            return response()->json(['message' => 'Nenhuma inscrição encontrada para este evento.'], 200);
        }

        return response()->json($registrations);
    }

    /**
     * Display a listing of registrations for a specific participant with relationships.
     */
    public function registrationsByParticipant($participant_id)
    {
        $registrations = Registration::with(['participant', 'event'])
            ->where('participant_id', $participant_id)
            ->get();

        if ($registrations->isEmpty()) {
            return response()->json(['message' => 'Nenhuma inscrição encontrada para este participante.'], 404);
        }

        return response()->json($registrations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

            try {
        $request->validate([
            'participant_id' => 'required|integer',
            'event_id' => 'required|integer'
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Dados inválidos.',
            'missing' => $e->errors()
        ], 422);
    }
                $participant = Participant::find($request->participant_id);

        if($participant == null){
            return response()->json(['message'=> 'Participante não existe.'],400);
        }

                $event = Event::find($request->event_id);

        if($event == null){
            return response()->json(['message'=> 'Evento não existe.'],400);
        }

        $registration = new Registration;
        $registration->participant_id = $request->participant_id;
        $registration->event_id = $request->event_id;
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
            return response()->json(['message' => 'Ingresso não encontrado.'], 404);
        }

        return response()->json($registration);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
            try {
        $request->validate([
            'participant_id' => 'required|integer',
            'event_id' => 'required|integer'
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Dados inválidos.',
            'missing' => $e->errors()
        ], 422);
    }
        $participant = Participant::find($request->participant_id);

        if($participant == null){
            return response()->json(['message'=> 'Participante não existe.'],400);
        }

        $event = Event::find($request->event_id);
        
        if($event == null){
            return response()->json(['message'=> 'Evento não existe.'],400);
        }

        $registration = Registration::find($id);

        if (!$registration) {
            return response()->json(['message' => 'Ingresso não encontrado.'], 404);
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
            return response()->json(['message' => 'Ingresso não encontrado.'], 404);
        }

        $registration->delete();

        return response()->json(['message' => 'Ingresso deletado com sucesso.']);
    }
}
