<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CtraderAccount extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'deleted'   => 'boolean',
        'swap_free' => 'boolean',
        'live'      => 'boolean'
    ];

    /**
     * @var string
     */
    protected $table = 'ctrader_accounts';
}
