<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_options')->insert([
            'name' => 'Usuario',
            'link' => 'user',
            'icon' => 'fas fa-user',
            'order' => 1,
            'menugroup_id' => 3
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Roles',
            'link' => 'role',
            'icon' => 'fas fa-users-cog',
            'order' => 2,
            'menugroup_id' => 3
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Tipos Usuario',
            'icon' => 'fas fa-users-slash',
            'link' => 'usertype',
            'order' => 4,
            'menugroup_id' => 3
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Accesos',
            'link' => 'access',
            'icon' => 'fas fa-people-arrows',
            'order' => 5,
            'menugroup_id' => 3
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Opciones de Menú',
            'icon' => 'fas fa-stream',
            'link' => 'menuoption',
            'order' => 6,
            'menugroup_id' => 3
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Grupos de Menú',
            'icon' => 'fas fa-list-ol',
            'link' => 'menugroup',
            'order' => 7,
            'menugroup_id' => 3
        ]);
        //end Grupo Usuarios

        DB::table('menu_options')->insert([
            'name' => 'Lista de Comprobantes',
            'icon' => 'fas fa-list-ol',
            'link' => 'billinglist',
            'order' => 7,
            'menugroup_id' => 5
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Nota de Crédito',
            'icon' => 'fas fa-list-ol',
            'link' => 'business',
            'order' => 7,
            'menugroup_id' => 5
        ]);

        DB::table('menu_options')->insert([
            'name' => 'Empresas',
            'icon' => 'fas fa-list-ol',
            'link' => 'business',
            'order' => 7,
            'menugroup_id' => 6
        ]);


        //administracion menu
        DB::table('menu_options')->insert([
            'name' => 'Pisos',
            'icon' => 'fas fa-h-square',
            'link' => 'floor',
            'order' => 7,
            'menugroup_id' => 1
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Tipos de Habitación',
            'icon' => 'fas fa-door-open',
            'link' => 'roomtype',
            'order' => 7,
            'menugroup_id' => 1
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Habitaciones',
            'icon' => 'fas fa-hotel',
            'link' => 'room',
            'order' => 7,
            'menugroup_id' => 1
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Servicios',
            'icon' => 'fas fa-concierge-bell',
            'link' => 'service',
            'order' => 7,
            'menugroup_id' => 1
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Categorías',
            'icon' => 'fas fa-layer-group',
            'link' => 'category',
            'order' => 7,
            'menugroup_id' => 1
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Unidades',
            'icon' => 'fas fa-dollar-sign',
            'link' => 'unit',
            'order' => 7,
            'menugroup_id' => 1
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Productos',
            'icon' => 'fas fa-shopping-cart',
            'link' => 'product',
            'order' => 7,
            'menugroup_id' => 1
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Conceptos',
            'icon' => 'fas fa-list-ol',
            'link' => 'concept',
            'order' => 7,
            'menugroup_id' => 1
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Clientes',
            'icon' => 'fas fa-male',
            'link' => 'people',
            'order' => 8,
            'menugroup_id' => 1
        ]);

        DB::table('menu_options')->insert([
            'name' => 'Reservas',
            'icon' => 'fas fa-bookmark',
            'link' => 'bookings',
            'order' => 1,
            'menugroup_id' => 7
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Lista de Reservas',
            'icon' => 'fas fa-list',
            'link' => 'bookinglist',
            'order' => 1,
            'menugroup_id' => 7
        ]);

        //VENTAS OPTIONS
        DB::table('menu_options')->insert([
            'name' => 'Venta de Productos',
            'icon' => 'fas fa-shopping-bag',
            'link' => 'sellproduct',
            'order' => 1,
            'menugroup_id' => 8
        ]);
        DB::table('menu_options')->insert([
            'name' => 'Venta de Servicios',
            'icon' => 'fas fa-store',
            'link' => 'sellservice',
            'order' => 2,
            'menugroup_id' => 8
        ]);
    }
}