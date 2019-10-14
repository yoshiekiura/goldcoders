<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ctrader extends Model
{
    /**
     * @var array
     */
    protected $dates = ['expires_in'];

    /**
     * @var array
     */
    protected $fillable = [
        'access_token',
        'refresh_token',
        'expires_in',
        'token_type',
        'user_id'
    ];

    /**
     * @var string
     */
    protected $table = 'ctrader_tokens';

    public function isExpired()
    {
        if (Carbon::parse($this->attributes['expires_in']) < Carbon::now()) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function paymaster()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
