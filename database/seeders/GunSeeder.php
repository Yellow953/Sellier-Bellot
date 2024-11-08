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
            'name' => 'Shooter',
            'make' => '',
            'price' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('guns')->insert([
            'name' => 'Pistol',
            'make' => '',
            'price' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('guns')->insert([
            'name' => 'Gun Cleaning',
            'make' => '',
            'price' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('guns')->insert([
            'name' => 'Glock 19',
            'make' => '',
            'price' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('guns')->insert([
            'name' => 'Glock 17',
            'make' => '',
            'price' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
