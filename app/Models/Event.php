<?php

namespace App\Models;

use App\Enums\EventCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
        'category',
        'groom_name',
        'bride_name',
        'event_date',
        'event_time',
        'venue_name',
        'venue_address',
        'venue_map_link',
        'subdomain',
        'custom_data',
        'password',
        'password_hint',
        'is_published',
        'expires_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'category'     => EventCategory::class,
            'event_date'   => 'date',
            'expires_at'   => 'datetime',
            'custom_data'  => 'array',
            'is_published' => 'boolean',
            'password'     => 'hashed',
            'views_count'  => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(EventGallery::class)->orderBy('sort_order');
    }

    public function wishes(): HasMany
    {
        return $this->hasMany(Wish::class)->latest();
    }

    public function approvedWishes(): HasMany
    {
        return $this->hasMany(Wish::class)->where('is_approved', true)->latest();
    }

    public function rsvpResponses(): HasMany
    {
        return $this->hasMany(RsvpResponse::class)->latest();
    }

    public function invitationUrl(): string
    {
        if ($this->subdomain && app()->isProduction()) {
            $host = parse_url(config('app.url'), PHP_URL_HOST);
            return 'https://' . $this->subdomain . '.' . $host;
        }

        return route('invitation.show', $this);
    }

    public function displayTitle(): string
    {
        $cat = $this->category instanceof EventCategory
            ? $this->category
            : EventCategory::from($this->category ?? 'wedding');

        if ($cat->isCoupleEvent() && $this->bride_name) {
            return "{$this->groom_name} & {$this->bride_name}";
        }

        return $this->groom_name;
    }

    public function coupleName(): string
    {
        return $this->displayTitle();
    }

    public function isPasswordProtected(): bool
    {
        return ! empty($this->password);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
