<?php

namespace App\Enums;

enum RsvpStatus: string
{
    case Yes   = 'yes';
    case No    = 'no';
    case Maybe = 'maybe';

    public function label(): string
    {
        return match($this) {
            self::Yes   => 'Attending',
            self::No    => 'Not Attending',
            self::Maybe => 'Maybe',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Yes   => 'success',
            self::No    => 'danger',
            self::Maybe => 'warning',
        };
    }
}
