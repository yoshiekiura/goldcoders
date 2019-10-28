<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'details' => 'array'
    ];

    /**
     * @var array
     */
    protected $fillable = ['name', 'type', 'active', 'for_payout', 'details'];

    /**
     * @var string
     */
    protected $table = 'gateways';

    /**
     * @param $query
     */
    public function scopeForPayout($query)
    {
        $query->where('for_payout', true);
    }

    /**
     * @param $query
     */
    public function scopeNotPayout($query)
    {
        $query->where('for_payout', false);
    }

    /**
     * @param $query
     */
    public function scopeOrderByName($query)
    {
        $query->orderBy('name');
    }
}
