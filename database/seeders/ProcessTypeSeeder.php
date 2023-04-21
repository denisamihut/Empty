<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('processtypes')->insert([
            'name' => 'VENTA',
            'description' => 'Venta de Productos/Servicios',
            'abbreviation' => 'V',
        ]);
        DB::table('processtypes')->insert([
            'name' => 'MOVIMIENTO DE CAJA',
            'description' => 'Movimiento de Caja',
            'abbreviation' => 'MC',
        ]);
        DB::table('processtypes')->insert([
            'name' => 'SERVICIO HOTEL',
            'description' => 'Servicio de Hotel',
            'abbreviation' => 'H',
        ]);
        DB::table('processtypes')->insert([
            'name' => 'COMPRA',
            'description' => 'Compra de Productos/Servicios',
            'abbreviation' => 'C',
        ]);
    }
}