<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('b_paymentstatuses')->insert([
            ['status' => 'در انتظار پرداخت'],
            ['status' => 'پرداخت‌شده'],
            ['status' => 'ناموفق'],
            ['status' => 'بازگشت وجه'],
        ]);
    }
}
