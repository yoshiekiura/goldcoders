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
                $query->where('fname', 'like', '%'.$search.'%')
                      ->orWhere('mname', 'like', '%'.$search.'%')
                      ->orWhere('lname', 'like', '%'.$search.'%')
                      ->orWhere('email', 'like', '%'.$search.'%');
            });
        })->when($filters['roles'] ?? null, function ($query, $roles) {
            // member , paymaster or admin
            $query->role($roles);
        })->when($filters['orderBy'] ?? null, function ($query, $orderBy) {
            $query->orderBy($orderBy);
        })->when($filters['sortBy'] ?? null, function ($query, $sortBy) {
            $query->orderBy($sortBy);
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ('with' === $trashed) {
                $query->withTrashed();
            } elseif ('only' === $trashed) {
                $query->onlyTrashed();
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
