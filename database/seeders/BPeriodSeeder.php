<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class BPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('b_periods')->insert([
            [
                'pk_period' => 1,
                'period' => 'ماهانه',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pk_period' => 2,
                'period' => 'سه ماهه',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pk_period' => 3,
                'period' => 'سالانه',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
