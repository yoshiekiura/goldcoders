<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRolesAndAbilities, Sluggable;

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
     * @var array
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

            /* if cookie is present */
            if ($sponsorID) {
                $sponsor     = self::find($sponsorID);
                $user->sp_id = $sponsor->id;
            }

            /* override cookie with current request */
            if ($sponsorID = request()->sponsor_id) {
                $sponsor     = self::find($sponsorID);
                $user->sp_id = $sponsor->id;
            }
        });
    }

    /**
     * Add Default Avatar
     *
     */
    public function getAvatarAttribute($value)
    {
        return empty($value) ? 'https://www.gravatar.com/avatar/'.md5(Str::lower($this->email)).'.jpg?s=200&d=mm' : url($value);
    }

    /**
     * @return mixed
     */
    public function getNameAttribute()
    {
        return $this->fname.' '.$this->lname;
    }

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->isAn('admin');
    }

    /**
     * @return mixed
     */
    public function isBanned()
    {
        return $this->isA('banned');
    }

    /**
     * @return mixed
     */
    public function isMember()
    {
        return $this->isA('member');
    }

    /**
     * @return mixed
     */
    public function isPaymaster()
    {
        return $this->isA('paymaster');
    }

    /**
     * Referrals Relationship
     *
     */
    public function referrals()
    {
        return $this->hasMany(static::class, 'sp_id');
    }

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
                      ->orWhere('lname', 'like', '%'.$search.'%')
                      ->orWhere('email', 'like', '%'.$search.'%');
            });
        })->when($filters['role'] ?? null, function ($query, $role) {
            $query->whereIs($role);
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
     * Override Password Reset Default Built in Laravel
     *
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

    /**
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
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

    /**
     * Sponsor Relationship
     *
     */
    public function sponsor()
    {
        return $this->belongsTo(static::class, 'sp_id');
    }

    /**
     * @return mixed
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
