<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaneSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lanes')->insert([
            'name' => '1 Hour Shooting',
            'price' => 50,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lanes')->insert([
            'name' => '1 Hour Shooting with Private Ammo IN',
            'price' => 100,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('lanes')->insert([
            'name' => '1 Hour Shooting with Private Ammo OUT',
            'price' => 80,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
