<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class MProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_products')->insert([
            [
                'pk_product' => 1,
                'product' => 'سیستم مدیریت تعمیرات',
                'productsec' => 'FSM',
                'isenable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
