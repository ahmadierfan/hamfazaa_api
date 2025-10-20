<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class BPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('b_plans')->insert([
            [
                'pk_plan' => 1,
                'fk_product' => 1,
                'plan' => 'Free For Ever',
                'duration_days' => 1000000,
                'price' => 0,
                'is_istrial' => false,
                'is_free' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pk_plan' => 2,
                'fk_product' => 1,
                'plan' => 'Test',
                'duration_days' => 10,
                'price' => 0,
                'is_istrial' => true,
                'is_free' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pk_plan' => 3,
                'fk_product' => 1,
                'plan' => 'Basic',
                'duration_days' => 30,
                'price' => 480000,
                'is_istrial' => false,
                'is_free' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pk_plan' => 4,
                'fk_product' => 1,
                'plan' => 'Standard',
                'duration_days' => 30,
                'price' => 8900000,
                'is_istrial' => false,
                'is_free' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pk_plan' => 5,
                'fk_product' => 1,
                'plan' => 'Pro',
                'duration_days' => 30,
                'price' => 13500000,
                'is_istrial' => false,
                'is_free' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
