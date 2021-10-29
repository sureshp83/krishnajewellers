<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomerLoan extends Model
{
    //

    public function loan_jewellary()
    {
        return $this->hasMany('App\Model\CustomerLoanJewellery','loan_id');
    }
}
