<?php

namespace App\Models;

use App\Enums\EventCategory;
use App\Enums\TemplateType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    protected $fillable = [
        'name',
        'type',
        'category',
        'thumbnail',
        'slug',
        'plan_id',
        'config_schema',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'type'          => TemplateType::class,
            'category'      => EventCategory::class,
            'config_schema' => 'array',
            'is_active'     => 'boolean',
        ];
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function isWebsite(): bool
    {
        return $this->type === TemplateType::Website;
    }

    public function isStatic(): bool
    {
        return $this->type === TemplateType::Static;
    }
}
