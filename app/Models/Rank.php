<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    /**
     * @param $rank
     */
    public static function findRank($rank)
    {
        return self::whereName($rank)->first();
    }
}
