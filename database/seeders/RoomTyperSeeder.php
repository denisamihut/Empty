<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTyperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_types')->insert([
            'name' => 'Room Type 1',
            'capacity' => 4,
            'price' => 100.00,
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('room_types')->insert([
            'name' => 'Room Type 2',
            'capacity' => 2,
            'price' => 50.00,
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('room_types')->insert([
            'name' => 'Room Type 3',
            'capacity' => 4,
            'price' => 90.00,
            'branch_id' => 1,
            'business_id' => 1,
        ]);
    }
}