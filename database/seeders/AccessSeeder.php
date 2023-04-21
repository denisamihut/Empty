<?php

namespace Database\Seeders;

use App\Models\MenuOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= MenuOption::count(); $i++) {
            DB::table('access')->insert([
                'usertype_id' => 1,
                'menuoption_id' => $i,
            ]);
        }
    }
}