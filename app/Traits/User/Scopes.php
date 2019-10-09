<?php

namespace App\Traits\User;

trait Scopes
{
    /**
     * @param $query
     * @param array    $filters
     */
    // fucking fix this to query profile for first and last name
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $names = explode(' ', $search);

                foreach ($names as $name) {
                    $query->where('fname', 'like', '%'.$name.'%')
                          ->orWhere('mname', 'like', '%'.$name.'%')
                          ->orWhere('lname', 'like', '%'.$name.'%')
                          ->orWhere('username', 'like', '%'.$name.'%');
                }
            });
        })->when($filters['sponsor'] ?? null, function ($query, $sponsor) {
            $query->whereHas('sponsor', function ($query) use ($sponsor) {
                $names = explode(' ', $sponsor);

                foreach ($names as $name) {
                    $query->where('fname', 'like', '%'.$name.'%')
                          ->orWhere('mname', 'like', '%'.$name.'%')
                          ->orWhere('lname', 'like', '%'.$name.'%')
                          ->orWhere('username', 'like', '%'.$name.'%');
                }
            });
        })->when($filters['role'] ?? null, function ($query, $role) {
            $query->role($role);
        })->when($filters['status'] ?? null, function ($query, $status) {
            if ('active' === $status) {
                $query->where('active', true);
            } elseif ('inactive' === $status) {
                $query->where('active', false);
            }
        });
    }

    /**
     * @param $query
     */
    public function scopeOrderByName($query)
    {
        $query->orderBy('lname')->orderBy('fname');
    }

    /**
     * @param $query
     * @param $ability
     */
    public function scopeWhereCan($query, $ability)
    {
        $query->where(function ($query) use ($ability) {
            // direct
            $query->whereHas('abilities', function ($query) use ($ability) {
                $query->byName($ability);
            });
            // through roles
            $query->orWhereHas('roles', function ($query) use ($ability) {
                $query->whereHas('abilities', function ($query) use ($ability) {
                    $query->byName($ability);
                });
            });
        });
    }
}
