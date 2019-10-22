<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CtraderAccount extends Model
{
    /**
     * @var mixed
     */
    public $incrementing = false;

    /**
     * @var mixed
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = [
        'deleted'                     => 'boolean',
        'swapFree'                    => 'boolean',
        'live'                        => 'boolean',
        'traderRegistrationTimestamp' => 'datetime'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'accountId';

    /**
     * @var string
     */
    protected $table = 'ctrader_accounts';

    public function getTraderRegistrationTimestampAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['traderRegistrationTimestamp'])->format('Y-m-d');
    }

    /**
     * @return mixed
     */
    public function paymaster()
    {
        return $this->belongsTo(User::class, 'paymaster_id');
    }

    /**
     * @param $query
     * @param array    $filters
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('accountId', 'like', '%'.$search.'%');
            });
        })->when($filters['broker'] ?? null, function ($query, $broker) {
            $query->where(function ($query) use ($broker) {
                $names = explode(' ', $broker);

                foreach ($names as $name) {
                    $query->where('brokerName', 'like', '%'.$name.'%');
                }
            });
        })->when($filters['leverage'] ?? null, function ($query, $leverage) {
            $query->where(function ($query) use ($leverage) {
                $query->where('leverage', 'like', '%'.$leverage.'%');
            });
        })->when($filters['currency'] ?? null, function ($query, $currency) {
            $query->where(function ($query) use ($currency) {
                $query->where('depositCurrency', 'like', '%'.$currency.'%');
            });
        })->when($filters['live'] ?? null, function ($query) {
            $query->where('live', true);
        })->when($filters['demo'] ?? null, function ($query) {
            $query->where('live', false);
        })->when($filters['status'] ?? null, function ($query, $status) {
            $query->where(function ($query) use ($status) {
                $query->where('AccountStatus', 'like', '%'.$status.'%');
            });
        });
    }

    /**
     * @param  $val
     * @return mixed
     */
    public function setTraderRegistrationTimestampAttribute($val)
    {
        return $this->attribute['traderRegistrationTimeStamp'] = intval($val) / 1000;
    }
}
