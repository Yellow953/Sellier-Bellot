<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaliberSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('calibers')->insert([
            'name' => '.90 mm',
            'make' => 'Caliber',
            'price' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('calibers')->insert([
            'name' => '.45 mm',
            'make' => 'Caliber',
            'price' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
