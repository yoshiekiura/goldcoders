<?php

namespace App\Models\CommissionType;

use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    // subscription are morphToMany with this model
    // basically One Subscription Can Have many Cycles Commission

    // We will create All Cycles in Advance so we will have a record
    // of the date and time the subscription will cycle
    // the only thing we will do is run a cron job that will toggle this
    // cylce as paid
}
