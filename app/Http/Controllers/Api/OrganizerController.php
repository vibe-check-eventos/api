<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Organizer::all();
    }

    /**
     * Login an organizer.
     */
    public function login(Request $request)
    {

            try {
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



        $organizer = Organizer::where('email', $request->email)->first();

        if (!$organizer || $organizer->password !== $request->password) {
            return response()->json(['message' => 'Credenciais inválidas.'], 401);
        }

        // In a real app, return a token here
        return response()->json(['message' => 'Login realizado com sucesso.', 'organizer' => $organizer]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
            try {
        $request->validate([
            'organizer_type' => 'required|boolean',
            'company_name' => 'required|string',
            'legal_name' => 'required|string',
            'cnpj' => 'required|string',
            'full_name' => 'required|string',
            'cpf' => 'required|string',
            'email' => 'required|email|unique:organizers',
            'password' => 'required|string'
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Dados inválidos.',
            'missing' => $e->errors()
        ], 422);
    }

        $organizer = Organizer::create([
            'organizer_type' => $request->organizer_type,
            'company_name' => $request->company_name,
            'legal_name' => $request->legal_name,
            'cnpj' => $request->cnpj,
            'full_name' => $request->full_name,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return response()->json($organizer, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $organizer = Organizer::find($id);
        if (!$organizer) {
            return response()->json(['message' => 'Organizador não encontrado.'], 404);
        }
        return $organizer;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
            try {
        $request->validate([
            'organizer_type' => 'required|boolean',
            'company_name' => 'required|string',
            'legal_name' => 'required|string',
            'cnpj' => 'required|string',
            'full_name' => 'required|string',
            'cpf' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Dados inválidos.',
            'missing' => $e->errors()
        ], 422);
    }

        $organizer = Organizer::find($id);
        if (!$organizer) {
            return response()->json(['message' => 'Organizador não encontrado.'], 404);
        }
        $organizer->update([
            'organizer_type' => $request->organizer_type,
            'company_name' => $request->company_name,
            'legal_name' => $request->legal_name,
            'cnpj' => $request->cnpj,
            'full_name' => $request->full_name,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return response()->json($organizer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $organizer = Organizer::find($id);

        if (!$organizer) {
            return response()->json(['message' => 'Organizador não encontrado.'], 404);
        }
        
        $organizer->delete();
        return response()->json(['message' => 'Organizador deletado com sucesso.']);
    }
}
