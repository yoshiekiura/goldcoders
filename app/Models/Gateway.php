<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    protected $table = 'gateways';
    protected $casts = [
        'details' => 'array'
    ];


    protected $fillable = ['name', 'type', 'active','for_payout','details'];

    public function scopeOrderByName($query)
    {
        $query->orderBy('name');
    }


    public function scopeForPayout($query)
    {
        $query->where('for_payout', true);
    }

}
