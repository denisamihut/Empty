<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'razon_social' => 'Hotel Casa Andina SAC',
            'nombre_comercial' => 'Hotel Casa Andina',
            'ruc' => '20488048378',
            'direccion' => 'Av. Antenor Orrego MzB Lte. 10',
            'telefono' => '924734622',
            'email' => 'hotel@gmail.com',
            'logo' => 'logo',
            'checkin' => '14:00',
            'checkout' => '12:00',
            'serie' => '02',
            'business_id' => 1,
            'branch_id' => 1,
        ]);
    }
}