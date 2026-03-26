<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessInfo extends Model
{
    protected $fillable = [
        'admin_id',
        'image',
        'business_type',
        'business_name',
        'phone_country_code',
        'phone_ist_code',
        'mobile_no',
        'country_name',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}