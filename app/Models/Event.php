<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use HasFactory;

    /**
     * Get the address that owns the event.
     */
    public function event_address(): BelongsTo
    {
        return $this->belongsTo(EventAddress::class);
    }

    /**
     * Get the organizer that owns the event.
     */
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'organizer_id',
        'name',
        'description',
        'capacity',
        'is_active',
        'event_address_id',
        'date'
    ];

    public $timestamps = false;

}
