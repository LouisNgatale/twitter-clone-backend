<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        // My personal account
        DB::table('users')->insert([
            'name' => 'Louis Ngatale',
            'email' => 'louisngatale@gmail.com',
            'username' => 'louisngatale',
            'dob' => '2000-08-12',
            'phone_number' => '0987654321',
            'password' => Hash::make('password'),
            'created_at' => now(),
        ]);

        foreach (range(1,10000) as $index) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->email ,
                'username' => $faker->unique()->userName,
                'dob' => $faker->date('Y-m-d',  '-18 years'),
                'phone_number' => $faker->phoneNumber,
                'password' => Hash::make('password'),
                'created_at' => now(),
            ]);
        }
    }
}
