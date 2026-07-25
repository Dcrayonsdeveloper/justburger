<?php

namespace Database\Seeders;

use App\Models\DiscountRule;
use Illuminate\Database\Seeder;

class DiscountRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            [
                'label' => 'Staff 5%',
                'percent' => 5,
                'max_cart_value' => null,
                'requires_pin' => false,
                'is_active' => true,
                'position' => 1,
            ],
            [
                'label' => 'Loyalty 10%',
                'percent' => 10,
                'max_cart_value' => null,
                'requires_pin' => false,
                'is_active' => true,
                'position' => 2,
            ],
            [
                'label' => 'Clearance 20%',
                'percent' => 20,
                'max_cart_value' => 200,
                'requires_pin' => true,
                'is_active' => true,
                'position' => 3,
            ],
            [
                'label' => 'Manager Override 30%',
                'percent' => 30,
                'max_cart_value' => null,
                'requires_pin' => true,
                'is_active' => true,
                'position' => 4,
            ],
        ];

        foreach ($rules as $rule) {
            DiscountRule::updateOrCreate(['label' => $rule['label']], $rule);
        }
    }
}
