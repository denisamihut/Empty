<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            'name' => 'Unit 1',
            'branch_id' => 1,
            'business_id' => 1,
        ]);
        DB::table('units')->insert([
            'name' => 'Unit 2',
            'branch_id' => 1,
            'business_id' => 1,
        ]);
    }
}
