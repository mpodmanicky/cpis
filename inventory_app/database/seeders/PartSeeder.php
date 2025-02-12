<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('parts')->insert([
                'name' => $faker->company,
                'serialnumber' => rand(10000,999999),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
