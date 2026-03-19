<?php

namespace Database\Seeders;

use App\Enums\EventCategory;
use App\Enums\PlanType;
use App\Enums\TemplateType;
use App\Enums\UserRole;
use App\Models\Plan;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->createAdminUser();
        $this->createPlans();
        $this->createTemplates();
    }

    private function createAdminUser(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@farahna.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
                'role'     => UserRole::Admin,
            ]
        );
    }

    private function createPlans(): void
    {
        $plans = [
            [
                'name'     => 'Free',
                'price'    => 0,
                'type'     => PlanType::Static,
                'features' => [
                    'static_invitation' => 'true',
                    'watermark'         => 'true',
                    'subdomain'         => 'false',
                    'guest_book'        => 'false',
                    'rsvp'              => 'false',
                ],
                'is_active' => true,
            ],
            [
                'name'     => 'Premium',
                'price'    => 199,
                'type'     => PlanType::Website,
                'features' => [
                    'static_invitation' => 'true',
                    'subdomain'         => 'true',
                    'guest_book'        => 'true',
                    'rsvp'              => 'true',
                    'gallery'           => 'true',
                    'watermark'         => 'false',
                    'templates_count'   => '3',
                ],
                'is_active' => true,
            ],
            [
                'name'     => 'VIP',
                'price'    => 399,
                'type'     => PlanType::Website,
                'features' => [
                    'everything_in_premium' => 'true',
                    'custom_domain'         => 'true',
                    'no_watermark'          => 'true',
                    'priority_support'      => 'true',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::firstOrCreate(['name' => $plan['name']], $plan);
        }
    }

    private function createTemplates(): void
    {
        $freePlan    = Plan::where('name', 'Free')->first();
        $premiumPlan = Plan::where('name', 'Premium')->first();

        if ($freePlan) {
            Template::firstOrCreate(
                ['slug' => 'elegant-gold'],
                [
                    'name'          => 'Elegant Gold',
                    'type'          => TemplateType::Static,
                    'category'      => EventCategory::Wedding->value,
                    'slug'          => 'elegant-gold',
                    'plan_id'       => $freePlan->id,
                    'config_schema' => null,
                    'is_active'     => true,
                ]
            );
        }

        if ($premiumPlan) {
            // Existing wedding templates
            Template::firstOrCreate(
                ['slug' => 'romantic-scroll'],
                [
                    'name'          => 'Romantic Scroll',
                    'type'          => TemplateType::Website,
                    'category'      => EventCategory::Wedding->value,
                    'slug'          => 'romantic-scroll',
                    'plan_id'       => $premiumPlan->id,
                    'config_schema' => null,
                    'is_active'     => true,
                ]
            );

            Template::firstOrCreate(
                ['slug' => 'wedding-modern'],
                [
                    'name'          => 'Wedding Modern',
                    'type'          => TemplateType::Website,
                    'category'      => EventCategory::Wedding->value,
                    'slug'          => 'wedding-modern',
                    'plan_id'       => $premiumPlan->id,
                    'config_schema' => null,
                    'is_active'     => true,
                ]
            );

            // Birthday templates
            Template::firstOrCreate(
                ['slug' => 'birthday-luxury'],
                [
                    'name'          => 'Birthday Luxury',
                    'type'          => TemplateType::Website,
                    'category'      => EventCategory::Birthday->value,
                    'slug'          => 'birthday-luxury',
                    'plan_id'       => $premiumPlan->id,
                    'config_schema' => null,
                    'is_active'     => true,
                ]
            );

            Template::firstOrCreate(
                ['slug' => 'confetti-pop'],
                [
                    'name'          => 'Confetti Pop',
                    'type'          => TemplateType::Website,
                    'category'      => EventCategory::Birthday->value,
                    'slug'          => 'confetti-pop',
                    'plan_id'       => $premiumPlan->id,
                    'config_schema' => null,
                    'is_active'     => true,
                ]
            );

            // Engagement templates
            Template::firstOrCreate(
                ['slug' => 'petal-blush'],
                [
                    'name'          => 'Petal Blush',
                    'type'          => TemplateType::Website,
                    'category'      => EventCategory::Engagement->value,
                    'slug'          => 'petal-blush',
                    'plan_id'       => $premiumPlan->id,
                    'config_schema' => null,
                    'is_active'     => true,
                ]
            );

            // Love Letter — romantic envelope experience
            Template::firstOrCreate(
                ['slug' => 'love-letter'],
                [
                    'name'          => 'Love Letter',
                    'type'          => TemplateType::Website,
                    'category'      => EventCategory::Wedding->value,
                    'slug'          => 'love-letter',
                    'plan_id'       => $premiumPlan->id,
                    'config_schema' => null,
                    'is_active'     => true,
                ]
            );

            // Neon Night — nightclub vibe
            Template::firstOrCreate(
                ['slug' => 'neon-night'],
                [
                    'name'          => 'Neon Night',
                    'type'          => TemplateType::Website,
                    'category'      => EventCategory::Wedding->value,
                    'slug'          => 'neon-night',
                    'plan_id'       => $premiumPlan->id,
                    'config_schema' => null,
                    'is_active'     => true,
                ]
            );

            // Wedding cosmic
            Template::firstOrCreate(
                ['slug' => 'galaxy-night'],
                [
                    'name'          => 'Galaxy Night',
                    'type'          => TemplateType::Website,
                    'category'      => EventCategory::Wedding->value,
                    'slug'          => 'galaxy-night',
                    'plan_id'       => $premiumPlan->id,
                    'config_schema' => null,
                    'is_active'     => true,
                ]
            );

            // Graduation
            Template::firstOrCreate(
                ['slug' => 'golden-cap'],
                [
                    'name'          => 'Golden Cap',
                    'type'          => TemplateType::Website,
                    'category'      => EventCategory::Graduation->value,
                    'slug'          => 'golden-cap',
                    'plan_id'       => $premiumPlan->id,
                    'config_schema' => null,
                    'is_active'     => true,
                ]
            );

            // Wedding boho/desert
            Template::firstOrCreate(
                ['slug' => 'desert-sunset'],
                [
                    'name'          => 'Desert Sunset',
                    'type'          => TemplateType::Website,
                    'category'      => EventCategory::Wedding->value,
                    'slug'          => 'desert-sunset',
                    'plan_id'       => $premiumPlan->id,
                    'config_schema' => null,
                    'is_active'     => true,
                ]
            );

            // Casino / birthday / wedding — bold dark card theme
            Template::firstOrCreate(
                ['slug' => 'casino-night'],
                [
                    'name'          => 'Casino Night',
                    'type'          => TemplateType::Website,
                    'category'      => EventCategory::Birthday->value,
                    'slug'          => 'casino-night',
                    'plan_id'       => $premiumPlan->id,
                    'config_schema' => null,
                    'is_active'     => true,
                ]
            );
        }
    }
}
