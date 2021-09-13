<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Follow and get following from all Users
        foreach (range(1,10000) as $index) {
            DB::table('follower_user')
                ->insert([
                    [
                    'user_id' => 1,
                    'follower_id' => $index,
                    'created_at' => now(),
                    ],[
                        'user_id' => $index,
                        'follower_id' => 1,
                        'created_at' => now(),
                    ]
                ]
            );
        }
    }
}
