<?php

namespace App\Enums;

enum PlanType: string
{
    case Static  = 'static';
    case Website = 'website';

    public function label(): string
    {
        return match($this) {
            self::Static  => 'Static Invitation',
            self::Website => 'Dynamic Website',
        };
    }
}
