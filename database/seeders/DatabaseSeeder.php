<?php

namespace Database\Seeders;

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
                    'slug'          => 'elegant-gold',
                    'plan_id'       => $freePlan->id,
                    'config_schema' => null,
                    'is_active'     => true,
                ]
            );
        }

        if ($premiumPlan) {
            Template::firstOrCreate(
                ['slug' => 'romantic-scroll'],
                [
                    'name'          => 'Romantic Scroll',
                    'type'          => TemplateType::Website,
                    'slug'          => 'romantic-scroll',
                    'plan_id'       => $premiumPlan->id,
                    'config_schema' => null,
                    'is_active'     => true,
                ]
            );
        }
    }
}
