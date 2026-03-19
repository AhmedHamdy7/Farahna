<?php

namespace App\Enums;

enum EventCategory: string
{
    case Wedding    = 'wedding';
    case Birthday   = 'birthday';
    case Engagement = 'engagement';
    case Graduation = 'graduation';
    case Corporate  = 'corporate';

    public function label(): string
    {
        return match($this) {
            self::Wedding    => 'فرح',
            self::Birthday   => 'عيد ميلاد',
            self::Engagement => 'خطوبة',
            self::Graduation => 'تخرج',
            self::Corporate  => 'مناسبة',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Wedding    => '💍',
            self::Birthday   => '🎂',
            self::Engagement => '💎',
            self::Graduation => '🎓',
            self::Corporate  => '🏢',
        };
    }

    /**
     * Whether this category has two named protagonists (couple).
     * Controls whether bride_name field is shown and required.
     */
    public function isCoupleEvent(): bool
    {
        return in_array($this, [self::Wedding, self::Engagement]);
    }

    /**
     * Returns [$primaryLabel, $secondaryLabel|null]
     */
    public function nameLabels(): array
    {
        return match($this) {
            self::Wedding    => ['اسم العريس', 'اسم العروسة'],
            self::Engagement => ['اسم الخطيب', 'اسم الخطيبة'],
            self::Birthday   => ['اسم صاحب/ة العيد', null],
            self::Graduation => ['اسم المتخرج/ة', null],
            self::Corporate  => ['اسم المناسبة', null],
        };
    }

    public function primaryPlaceholder(): string
    {
        return match($this) {
            self::Wedding    => 'مثال: أحمد',
            self::Engagement => 'مثال: كريم',
            self::Birthday   => 'مثال: سارة',
            self::Graduation => 'مثال: محمد',
            self::Corporate  => 'مثال: شركة المستقبل',
        };
    }
}
