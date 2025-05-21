<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'organizer_id' => 'required|integer',
            'name' => 'required|string',
            'description' => 'required|string',
            'capacity' => 'required|integer',
            'is_active' => 'required|boolean',
            'address_event_id' => 'required|integer'
        ]);

        $event = Event::create([
            'organizer_id' => $request->organizer_id,
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active,
            'capacity' => $request->capacity,
            'address_event_id' => $request->address_event_id,
        ]);

        return response()->json([
            'message' => 'Event created successfully!',
            'event' => $event,
        ], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::with(['organizer', 'event_address'])->find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found!'], 404);
        }

        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found!'], 404);
        }

        $event->update([
            'organizer_id' => $request->organizer_id,
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active,
            'capacity' => $request->capacity,
            'address_event_id' => $request->address_event_id,
        ]);

        return response()->json(['message' => 'Event updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found!'], 404);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully!'], 200);

    }
}
