<?php

use App\Models\Rank;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $ranks = config('ranks');
        foreach ($ranks as $name) {
            $rank = new Rank();
            $rank->name = $name;
            $rank->save();
            # code...
        }
    }
}
