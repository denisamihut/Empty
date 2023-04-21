<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->insert([
            'name' => 'EFECTIVO',
            'type' => 'cash',
            'business_id' => 1,
        ]);

        DB::table('payments')->insert([
            'name' => 'VISA',
            'type' => 'card',
            'business_id' => 1,
        ]);

        DB::table('payments')->insert([
            'name' => 'YAPE',
            'type' => 'transfer',
            'business_id' => 1,
        ]);

        DB::table('payments')->insert([
            'name' => 'PLIN',
            'type' => 'transfer',
            'business_id' => 1,
        ]);

        DB::table('payments')->insert([
            'name' => 'COMBINADO',
            'type' => 'others',
            'business_id' => 1,
        ]);
    }
}