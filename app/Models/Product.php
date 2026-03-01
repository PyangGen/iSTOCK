<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'pd_id';

    protected $fillable = [
        'pd_photo',
        'pd_name',
        'pd_desc',
        'pd_code',
        'pd_qty',
        'pd_unit',
        'pd_cost_price',
        'pd_price',
        'category_id',
        'pd_supplier',
        'pd_expiry_date',
        'pd_updateDate',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}