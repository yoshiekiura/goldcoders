<?php

namespace App\Models;

use App\Traits\User\Scopes;
use App\Traits\User\Methods;
use App\Traits\User\Mutators;
use App\Traits\User\Relationships;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, HasRoles, Sluggable, Mutators, Relationships, Methods, Scopes, HasMediaTrait;

    /**
     * @var array
     */
    protected $appends = ['permission_list', 'can', 'role_list', 'name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active'            => 'boolean'
    ];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var arrayApt. 792
     */
    protected $fillable = [
        'email', 'password', 'username', 'active',
        'mobile_no', 'current_address', 'permanent_address',
        'fname', 'mname', 'lname',
        'suffix', 'dob', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * @var string
     */
    protected $table = 'users';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            /* Our Default Referral Link if No Cookie Is Present */
            $user->sp_id = optional(self::first())->id;
            /* change this */
            $sponsorID = \Cookie::get('sponsor');

            if ($sponsorID) {
                /* check if cookie is present */
                $sponsor     = self::find($sponsorID);
                $user->sp_id = $sponsor->id;
            }

            if ($sponsorID = request()->sp_id) {
                /* override cookie with current request */
                $sponsor     = self::find($sponsorID);
                $user->sp_id = $sponsor->id;
            }
        });
    }

    /**
     * Override Password Reset Default Built in Laravel
     *
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

    /**
     * The attributes that should be Slugify
     *
     */
    public function sluggable()
    {
        return [
            'username' => [
                'source' => 'username'
            ]
        ];
    }
}
