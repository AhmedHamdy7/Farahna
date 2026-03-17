<?php

namespace App\Models;

use App\Enums\PlanType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'features',
        'type',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'features'  => 'array',
            'price'     => 'decimal:2',
            'type'      => PlanType::class,
            'is_active' => 'boolean',
        ];
    }

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }

    public function isFree(): bool
    {
        return $this->price == 0;
    }
}
