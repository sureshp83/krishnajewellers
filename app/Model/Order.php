<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use SoftDeletes;
    
    protected $fillable = [
        'customer_id',
        'category_id',
        'jewellery_name',
        'description',
        'weight',
        'current_rate',
        'making_charge',
        'other_charge'
    ];
}