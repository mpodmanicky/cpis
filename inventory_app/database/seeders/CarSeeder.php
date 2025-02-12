<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $isRegistered = rand(0,1);

        for ($i = 0; $i < 10; $i++) {
            DB::table('cars')->insert([
                'name' => $faker->company,
                'registration_number' => $isRegistered ? rand(10000,999999) : null,
                'is_registered' => $isRegistered,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
