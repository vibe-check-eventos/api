<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventAddress;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EventAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventAddresses = EventAddress::all();

        return response()->json($eventAddresses);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            try {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'street' => 'required|string',
            'number' => 'nullable|string',
            'complement' => 'nullable|string',
            'neighborhood' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip_code' => 'nullable|string',
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Dados inválidos.',
            'missing' => $e->errors()
        ], 422);
    }


        $eventAddress = EventAddress::create($validatedData); // Replace with $validatedData if using validation
        return response()->json($eventAddress, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $eventAddress = EventAddress::find($id);
        if (!$eventAddress) {
            return response()->json(['message' => 'Endereço de evento não encontrado.'], 404);
        }
        return response()->json($eventAddress);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $eventAddress = EventAddress::find($id);
        if (!$eventAddress) {
            return response()->json(['message' => 'Endereço de evento não encontrado.'], 404);
        }

            try {
      // Validate the incoming request data
        $validatedData = $request->validate([
            'street' => 'sometimes|string',
            'number' => 'required|string',
            'complement' => 'nullable|string',
            'neighborhood' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Dados inválidos.',
            'missing' => $e->errors()
        ], 422);
    }
  
        $eventAddress->update($request->all()); // Replace with $validatedData if using validation
        return response()->json($eventAddress);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $eventAddress = EventAddress::find($id);
        if (!$eventAddress) {
            return response()->json(['message' => 'Endereço de evento não encontrado.'], 404);
        }
        $eventAddress->delete();
        return response()->json(['message' => 'Endereço de evento deletado com sucesso.']);
    }
}
