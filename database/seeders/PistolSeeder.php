<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PistolSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pistols')->insert([
            'name' => 'Shooter',
            'make' => '',
            'price' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('pistols')->insert([
            'name' => 'Pistol',
            'make' => '',
            'price' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('pistols')->insert([
            'name' => 'Pistol Cleaning',
            'make' => '',
            'price' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('pistols')->insert([
            'name' => 'Glock 17 MOS',
            'make' => '',
            'price' => 12,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
