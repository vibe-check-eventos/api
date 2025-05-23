<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAddress;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with(['organizer', 'event_address'])->get();

        return response()->json($events);
    }
  
    /**
     * Display a listing of events for a specific organizer.
     */
    public function eventsByOrganizer($organizer_id)
    {
        $events = Event::with(['organizer', 'event_address'])
            ->where('organizer_id', $organizer_id)
            ->get();

        if ($events->isEmpty()) {
            return response()->json(['message' => 'Nenhum evento encontrado para este organizador.'], 404);
        }

        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //dd($request->all());
            try {
        $request->validate([
            'organizer_id' => 'required|integer',
            'name' => 'required|string',
            'description' => 'required|string',
            'capacity' => 'required|integer',
            'is_active' => 'required|boolean',
            'event_address_id' => 'required|integer'
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Dados inválidos.',
            'missing' => $e->errors()
        ], 422);
    }
        $address = EventAddress::find($request->address_id);

        if($address == null){
            return response()->json(['message'=> 'Endereço de evento não existe.'],400);
        }

        $event = Event::create($request->all());

        return response()->json($event, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::with(['organizer', 'event_address'])->find($id);

        if (!$event) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

            try {
        $request->validate([
            'organizer_id' => 'required|integer',
            'name' => 'required|string',
            'description' => 'required|string',
            'capacity' => 'required|integer',
            'is_active' => 'required|boolean',
            'event_address_id' => 'required|integer'
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Dados inválidos.',
            'missing' => $e->errors()
        ], 422);
    }

        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }
        
        $address = EventAddress::find($request->address_id);

        if($address == null){
            return response()->json(['message'=> 'Endereço de evento não existe.'],400);
        }

        $event->update([
            'organizer_id' => $request->organizer_id,
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active,
            'capacity' => $request->capacity,
            'event_address_id' => $request->event_address_id,
        ]);

        return response()->json($event, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        $event->delete();

        return response()->json(['message' => 'Evento deletado com sucesso.'], 200);

    }
}
