<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class MSubscription extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_subscriptions')->insert([
            [
                'pk_subscription' => 1,
                'fk_company' => 1,
                'fk_product' => 1,
                'fk_plan' => 1,
                'start_date' => "2024-12-15",
                'end_date' => "2094-12-15",
                "max_users" => 10000,
                "current_users" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
