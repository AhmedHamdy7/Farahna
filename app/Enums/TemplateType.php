<?php

namespace App\Enums;

enum TemplateType: string
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
