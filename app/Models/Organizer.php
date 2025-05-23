<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organizer extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'organizer_type',
        'company_name',
        'legal_name',
        'cnpj',
        'full_name',
        'cpf',
        'email',
        'password'
    ];

}
