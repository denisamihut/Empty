<?php

namespace Database\Seeders;

use App\Models\Process;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('processes')->insert([
            'date' => '2021-01-01',
            'number' => '2022-00001',
            'processtype_id' => 2,
            'concept_id' => 1,
            'user_id' => 1,
            'client_id' => 1,
            'branch_id' => 1,
            'business_id' => 1,
            'cashbox_id' => 1,
            'status' => 'C',
            'amount' => 1000,
            'notes' => 'Apertura de caja',
            'created_at' => '2021-01-01 00:00:00',
        ]);
        Process::factory()->count(50)->create();
    }
}