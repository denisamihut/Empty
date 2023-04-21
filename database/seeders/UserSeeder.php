<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'usertype_id' => 1,
            'business_id' => 1,
            'cashbox_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Administrador 1',
            'email' => 'administrador@gmail.com',
            'password' => bcrypt('123456'),
            'usertype_id' => 2,
            'business_id' => 1,
            'cashbox_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Cajero 1',
            'email' => 'cajero@gmail.com',
            'password' => bcrypt('123456'),
            'usertype_id' => 3,
            'business_id' => 1,
            'cashbox_id' => 1,
        ]);
    }
}