<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business')->insert([
            'name' => 'HOTEL PRUEBA',
            'address' => 'Av. Prueba 123 - Chiclayo',
            'phone' => '924734626',
            'email' => 'prueba@gmail.com',
            'city' => 'Chiclayo',
        ]);
    }
}