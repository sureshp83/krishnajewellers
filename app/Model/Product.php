<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'product_name',
        'category_id',
        'description'
    ];

    public function productImages()
    {
        return $this->hasMany('App\Model\ProductImage', 'product_id');
    }
}
