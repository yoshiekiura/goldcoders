<?php

namespace App\Traits\Subscription;

trait Methods
{
    /**
     * Add Last Method
     *
     */
    public static function last()
    {
        return self::latest()->first();
    }
}
