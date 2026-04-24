<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restock extends Model
{
    protected $fillable = [
        'product_id',
        'qty',
        'supplier',
        'restock_date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
