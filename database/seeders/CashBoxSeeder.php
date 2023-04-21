<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CashBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cashboxes')->insert([
            'name' => 'Caja 1',
            'phone' => '123456789',
            'comments' => 'Caja 1',
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('cashboxes')->insert([
            'name' => 'Caja 2',
            'phone' => '123456789',
            'comments' => 'Caja 1',
            'branch_id' => 1,
            'business_id' => 1,
        ]);
    }
}