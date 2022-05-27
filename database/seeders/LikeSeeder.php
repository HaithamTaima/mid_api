<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // pivot table
        foreach(range(1, 100) as $index)
        {
            DB::table('user_like')->insert([
                'tweet_id' => rand(1,50),
                'user_id' => rand(1,50)
            ]);
        }
    }
}
