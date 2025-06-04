<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'qr_code_base64',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}