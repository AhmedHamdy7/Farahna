<?php

namespace App\Models;

use App\Enums\RsvpStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RsvpResponse extends Model
{
    protected $fillable = [
        'event_id',
        'guest_name',
        'phone',
        'attending',
        'guests_count',
    ];

    protected function casts(): array
    {
        return [
            'attending'    => RsvpStatus::class,
            'guests_count' => 'integer',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function scopeAttending($query)
    {
        return $query->where('attending', RsvpStatus::Yes);
    }
}
