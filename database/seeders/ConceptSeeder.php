<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('concepts')->insert([
            'name' => 'Apertura de caja',
            'type' => 'I',
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('concepts')->insert([
            'name' => 'Cierre de caja',
            'type' => 'E',
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('concepts')->insert([
            'name' => 'Venta a Cliente',
            'type' => 'I',
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('concepts')->insert([
            'name' => 'Servicio de Hotel',
            'type' => 'I',
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('concepts')->insert([
            'name' => 'Otros Ingresos',
            'type' => 'I',
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('concepts')->insert([
            'name' => 'Otros Egresos',
            'type' => 'E',
            'branch_id' => 1,
            'business_id' => 1,
        ]);
    }
}