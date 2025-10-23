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
                'plan' => 'آزمایشی',
                'subtitle' => 'آزمایشی',
                'maxusers' => 5,
                'max_room' => 1,
                'price' => null,
                'icon' => '',
                'options' => json_encode([
                    'پشتیبانی VIP',
                    'گزارش‌گیری پیشرفته',
                ]),
                'seasonaldiscount' => 0,
                'annuallydiscount' => 0,
                'istrial' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pk_plan' => 2,
                'fk_product' => 1,
                'plan' => 'پایه',
                'subtitle' => 'تیم های کوچک',
                'maxusers' => 15,
                'max_room' => 3,
                'price' => json_encode([
                    4800000,
                    3840000,
                    3120000
                ]),
                'icon' => '
                                               <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                ',
                'options' => json_encode([
                    'پشتیبانی VIP',
                    'گزارش‌گیری پیشرفته',
                ]),
                'seasonaldiscount' => 20,
                'annuallydiscount' => 35,
                'istrial' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pk_plan' => 3,
                'fk_product' => 1,
                'plan' => 'حرفه‌ای',
                'subtitle' => 'شرکتی',
                'maxusers' => 50,
                'max_room' => 7,
                'price' => json_encode([
                    12000000,
                    9600000,
                    7800000
                ]),
                'icon' => '
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                ',
                'options' => json_encode([
                    'پشتیبانی VIP',
                    'گزارش‌گیری پیشرفته',
                ]),
                'seasonaldiscount' => 20,
                'annuallydiscount' => 35,
                'istrial' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pk_plan' => 4,
                'fk_product' => 1,
                'plan' => 'پیشرفته',
                'subtitle' => 'سازمانی',
                'maxusers' => 150,
                'max_room' => 35, // نامحدود
                'price' => json_encode([
                    24000000,
                    19200000,
                    15600000
                ]),
                'icon' => '
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                ',
                'options' => json_encode([
                    'پشتیبانی VIP',
                    'گزارش‌گیری پیشرفته',
                ]),
                'seasonaldiscount' => 20,
                'annuallydiscount' => 35,
                'istrial' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
