<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('interests')->truncate();
        DB::table('interests')->insert([
            'title' => 'reading'
        ]);

        DB::table('interests')->insert([
            'title' => 'Video Games'
        ]);
        DB::table('interests')->insert([
            'title' => 'Sports'
        ]);
        DB::table('interests')->insert([
            'title' => 'Travelling'
        ]);
    }
}
