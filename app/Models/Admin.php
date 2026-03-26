<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'password',
    'google_id',
    'avatar',
    'is_verified'
];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function businessInfo()
{
    return $this->hasOne(\App\Models\BusinessInfo::class);
}
}
