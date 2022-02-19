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
        'weight_type',
        'current_rate',
        'making_charge',
        'other_charge',
        'payment_type'
    ];

    public function order_payments()
    {
        return $this->hasMany('App\Model\OrderPayment', 'order_id');
    }
}
