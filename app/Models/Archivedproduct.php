<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivedProduct extends Model
{
    use HasFactory;

    protected $table = 'archived_products';

    protected $fillable = [
        'pd_name',
        'pd_code',
        'category_id',
        'pd_qty',
        'pd_unit',
        'pd_price',
        'pd_desc',
        'pd_photo'
    ];
}