<?php

namespace App\Traits\User;

trait Methods
{
    /**
     * @return mixed
     */
    public function canBeImpersonated()
    {
        return 1 !== $this->can_be_impersonated;
    }

    /**
     * @return mixed
     */
    public function canImpersonate()
    {
        return $this->isSuperAdmin();
    }

    /**
     * Add findByEmail Method
     *
     */
    public static function findByEmail($email)
    {
        return self::whereEmail($email)->first();
    }

    /**
     * Add findByUsername Method
     *
     */
    public static function findByUsername($username)
    {
        return self::whereUsername($username)->first();
    }

    /**
     * Add findForPassport Method
     *
     */
    public function findForPassport($identifier)
    {
        return $this->orWhere('email', $identifier)->orWhere('username', $identifier)->first();
    }

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * @return mixed
     */
    public function isBanned()
    {
        return $this->hasRole('banned');
    }

    /**
     * @return mixed
     */
    public function isMember()
    {
        return $this->hasRole('member');
    }

    /**
     * @return mixed
     */
    public function isPaymaster()
    {
        return $this->hasRole('paymaster');
    }

    /**
     * @return mixed
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('admin') && 1 === $this->id;
    }

    /**
     * Add Last Method
     *
     */
    public static function last()
    {
        return self::latest()->first();
    }
}
