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
            'name' => '6.35 Browning',
            'make' => '',
            'price' => 75,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('calibers')->insert([
            'name' => '22LR',
            'make' => '',
            'price' => 25,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('calibers')->insert([
            'name' => '7.65 Browning',
            'make' => '',
            'price' => 75,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('calibers')->insert([
            'name' => '9 Short',
            'make' => '',
            'price' => 75,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('calibers')->insert([
            'name' => '9 Makarov',
            'make' => '',
            'price' => 75,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('calibers')->insert([
            'name' => '9mm',
            'make' => '',
            'price' => 45,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('calibers')->insert([
            'name' => 'Tokarev',
            'make' => '',
            'price' => 100,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('calibers')->insert([
            'name' => '40 S&W',
            'make' => '',
            'price' => 60,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('calibers')->insert([
            'name' => '45 Auto',
            'make' => '',
            'price' => 75,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('calibers')->insert([
            'name' => '357 MGN',
            'make' => '',
            'price' => 75,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('calibers')->insert([
            'name' => '44 MGN',
            'make' => '',
            'price' => 100,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('calibers')->insert([
            'name' => '38 SPE',
            'make' => '',
            'price' => 60,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
