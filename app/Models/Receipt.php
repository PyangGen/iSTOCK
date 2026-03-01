<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    //
    protected $fillable = [
    'supplier_name',
    'product_source',
    'deliver_date',
    'photo_one',
    'photo_two',
];
}
