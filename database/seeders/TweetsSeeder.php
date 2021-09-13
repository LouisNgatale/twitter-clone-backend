<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TweetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        foreach (range(1,10000) as $index) {
            DB::table('tweets')->insert([
                'body' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'author_id' => rand(1,1000),
                'created_at' => now(),
            ]);
        }
    }
}
