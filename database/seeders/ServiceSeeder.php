<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            'name' => 'Service 1',
            'description' => 'Description 1',
            'price' => 30,
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('services')->insert([
            'name' => 'Service 2',
            'description' => 'Description 2',
            'price' => 40,
            'branch_id' => 1,
            'business_id' => 1,
        ]);
    }
}
