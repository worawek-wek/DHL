<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const ADMIN_ROLE = 1;
    const SHIPPING_ROLE = 2;
    const FINANCE_ROLE = 3;
    const BILLING_ROLE = 4;
    const DEFAULT_TYPE = 0;

    public function isAdmin(){
        return $this->role === self::ADMIN_ROLE;
    }
    public function isShipping(){
        return $this->role === self::SHIPPING_ROLE;
    }
    public function isFinance(){
        return $this->role === self::FINANCE_ROLE;
    }
    public function isBilling(){
        return $this->role === self::BILLING_ROLE;
    }
}
