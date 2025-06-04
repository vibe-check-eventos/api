<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QrCode;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function index()
    {
        return QrCode::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'qr_code_base64' => 'required|string',
        ]);

        $qrCode = QrCode::create($validated);

        return response()->json($qrCode, 201);
    }

    public function getByParticipant($participantId)
    {
        $qrCodes = QrCode::whereHas('registration.participant', function ($query) use ($participantId) {
            $query->where('id', $participantId);
        })
        ->with([
            'registration',
            'registration.participant',
            'registration.event',
            'registration.event.event_address',
            'registration.event.organizer'
        ])
        ->get();

        return response()->json($qrCodes);
    }

    public function show(QrCode $qrCode)
    {
        return $qrCode;
    }

    public function update(Request $request, QrCode $qrCode)
    {
        $validated = $request->validate([
            'qr_code_base64' => 'sometimes|required|string',
        ]);

        $qrCode->update($validated);

        return response()->json($qrCode);
    }

    public function destroy(QrCode $qrCode)
    {
        $qrCode->delete();

        return response()->json(null, 204);
    }
}