<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CorridorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('corridors')->insert([
            'name' => 'ROW 1',
            'price' => 25,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('corridors')->insert([
            'name' => 'ROW 2',
            'price' => 25,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
