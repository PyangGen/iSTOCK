<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivedProduct extends Model
{
    use HasFactory;

    protected $table = 'archived_products';

    protected $fillable = [
    'pd_photo',
    'pd_name',
    'pd_code',
    'pd_desc',
    'pd_qty',
    'pd_unit',
    'pd_cost_price',
    'pd_price',
    'category_id',
    'pd_supplier',
    'pd_expiry_date',
];
}