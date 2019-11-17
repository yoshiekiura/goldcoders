<?php

namespace App\Models;

use App\Traits\Subscription\Methods;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Subscription\Relationships;

class Subscription extends Model
{
    use Relationships, Methods;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscriptions';
}
