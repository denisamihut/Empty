<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_groups')->insert([
            'name' => 'Administración',
            'icon' => 'fas fa-users-cog',
            'order' => 1,
        ]);
        DB::table('menu_groups')->insert([
            'name' => 'Personas',
            'icon' => 'fas fa-user-tie',
            'order' => 2,
        ]);
        DB::table('menu_groups')->insert([
            'name' => 'Usuarios',
            'icon' => 'fas fa-users',
            'order' => 3,
        ]);
        DB::table('menu_groups')->insert([
            'name' => 'Reportes',
            'icon' => 'fas fa-chart-bar',
            'order' => 4,
        ]);
        DB::table('menu_groups')->insert([
            'name' => 'F. Electrónica',
            'icon' => 'fas fa-chart-bar',
            'order' => 5,
        ]);
        DB::table('menu_groups')->insert([
            'name' => 'Configuraciones',
            'icon' => 'fas fa-chart-bar',
            'order' => 6,
        ]);
        DB::table('menu_groups')->insert([
            'name' => 'Reservas',
            'icon' => 'fas fa-book',
            'order' => 7,
        ]);
        DB::table('menu_groups')->insert([
            'name' => 'Ventas',
            'icon' => 'fas fa-shopping-cart',
            'order' => 3,
        ]);
    }
}