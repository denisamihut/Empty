<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Product 1',
            'sale_price' => 30.00,
            'purchase_price' => 25.00,
            'unit_id' => 1,
            'category_id' => 1,
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('products')->insert([
            'name' => 'Product 2',
            'sale_price' => 40.00,
            'purchase_price' => 35.00,
            'unit_id' => 1,
            'category_id' => 2,
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('products')->insert([
            'name' => 'Product 3',
            'sale_price' => 30.00,
            'purchase_price' => 25.00,
            'unit_id' => 1,
            'category_id' => 1,
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('products')->insert([
            'name' => 'Product 4',
            'sale_price' => 40.00,
            'purchase_price' => 35.00,
            'unit_id' => 1,
            'category_id' => 2,
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('products')->insert([
            'name' => 'Product 5',
            'sale_price' => 30.00,
            'purchase_price' => 25.00,
            'unit_id' => 1,
            'category_id' => 1,
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('products')->insert([
            'name' => 'Product 6',
            'sale_price' => 40.00,
            'purchase_price' => 35.00,
            'unit_id' => 1,
            'category_id' => 2,
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('products')->insert([
            'name' => 'Product 7',
            'sale_price' => 30.00,
            'purchase_price' => 25.00,
            'unit_id' => 1,
            'category_id' => 1,
            'branch_id' => 1,
            'business_id' => 1,
        ]);

        DB::table('products')->insert([
            'name' => 'Product 8',
            'sale_price' => 40.00,
            'purchase_price' => 35.00,
            'unit_id' => 1,
            'category_id' => 2,
            'branch_id' => 1,
            'business_id' => 1,
        ]);
    }
}