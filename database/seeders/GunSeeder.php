<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GunSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('guns')->insert([
            'name' => 'Desert Eagle',
            'make' => 'Beretta',
            'price' => 25,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('guns')->insert([
            'name' => 'AK 47',
            'make' => 'AK',
            'price' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
