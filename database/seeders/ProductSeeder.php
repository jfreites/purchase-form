<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
            [
                'sku'        => 'SKU01',
                'price'      => '125.50',
                'created_at' => Carbon::now(),
            ],
            [
                'sku'        => 'SKU02',
                'price'      => '210.00',
                'created_at' => Carbon::now(),
            ],
            [
                'sku'        => 'SKU03',
                'price'      => '50.00',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
