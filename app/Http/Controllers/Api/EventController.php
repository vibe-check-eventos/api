<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with(['organizer', 'event_address'])->inRandomOrder()->get();

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
            return response()->json(['message' => 'Nenhum evento encontrado para este organizador.'], 200);
        }

        return response()->json($events);
    }

/**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'organizer_id' => 'required|integer',
                'name' => 'required|string',
                'description' => 'required|string',
                'capacity' => 'nullable|integer',
                'is_active' => 'nullable|boolean',
                'event_address_id' => 'required|integer',
                'date' => 'required|string' // Alterado de 'created_at' para 'date'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Dados inválidos.',
                'missing' => $e->errors()
            ], 422);
        }

        $address = EventAddress::find($request->event_address_id);

        if ($address == null) {
            return response()->json(['message' => 'Endereço de evento não existe.'], 400);
        }

        // 1. Parsear 'date' para o formato do banco de dados (Y-m-d H:i:s)
        $eventDate = null;
        try {
            $dateString = $request->date; // Usando $request->date
            if (preg_match('/^\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}$/', $dateString)) {
                $eventDate = Carbon::createFromFormat('d/m/Y H:i', $dateString)->format('Y-m-d H:i:s');
            } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dateString)) {
                $eventDate = Carbon::createFromFormat('d/m/Y', $dateString)->startOfDay()->format('Y-m-d H:i:s');
            } else {
                throw new \Exception('Formato de data inválido.');
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Formato de data inválido. Use dd/mm/yyyy ou dd/mm/yyyy HH:ii.'], 422);
        }

        // Prepara os dados para a criação do evento, incluindo a data parseada.
        $eventData = $request->all();
        $eventData['date'] = $eventDate;

        // Cria o evento diretamente com a 'date' correta.
        // Certifique-se de que 'date' está no $fillable do modelo Event.
        $event = Event::create($eventData);

        // O accessor no modelo (se houver um para 'date') cuidará da formatação para o JSON de retorno.
        return response()->json($event, 200);
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

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'organizer_id' => 'integer',
            'name' => 'required|string',
            'description' => 'required|string',
            'capacity' => 'integer',
            'is_active' => 'boolean',
            'address' => 'string', // Novo campo para atualizar o endereço
            'date' => 'string', // Formato dd/mm/yyyy ou dd/mm/yyyy HH:ii
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Dados inválidos.',
                'missing' => $validator->errors()
            ], 200);
        }

        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Evento não encontrado.'], 200);
        }

        // Atualiza o endereço se enviado
        if ($request->has('address')) {
            $eventAddress = EventAddress::find($event->event_address_id);
            if (!$eventAddress) {
                return response()->json(['message'=> 'Endereço de evento não existe.'],200);
            }
            $eventAddress->street = $request->address;
            $eventAddress->save();
        }

        // Atualiza o created_at se enviado
        if ($request->has('date')) {
            $dateString = $request->date;
            try {
                // Tenta com hora e minuto
                if (preg_match('/^\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}$/', $dateString)) {
                    $date = Carbon::createFromFormat('d/m/Y H:i', $dateString);
                } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dateString)) {
                    $date = Carbon::createFromFormat('d/m/Y', $dateString)->startOfDay();
                } else {
                    throw new \Exception('Formato de data inválido.');
                }
                $event->created_at = $date->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                return response()->json(['message' => 'Formato de data inválido. Use dd/mm/yyyy ou dd/mm/yyyy HH:ii.'], 422);
            }
        }

        $event->update([
            'organizer_id' => $request->organizer_id ?? $event->organizer_id,
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->is_active ?? $event->is_active,
            'capacity' => $request->capacity ?? $event->capacity,
        ]);

        // Salva o created_at se foi alterado
        if ($request->has('date')) {
            $event->save();
        }

        return response()->json($event->fresh(['organizer', 'event_address']), 200);
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
