<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('customers')->insert([
            'name' => 'Joe Mazloum',
            'phone' => '+96170285659',
            'address' => 'kaakour',
            'document_type' => 'Personal ID',
            'document1' => '/assets/images/default_profile.png',
            'document2' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('customers')->insert([
            'name' => 'Hans Meier',
            'phone' => '+4915204820649',
            'address' => 'Gronau',
            'document_type' => 'Gun Permit',
            'document1' => '/assets/images/default_profile.png',
            'document2' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
