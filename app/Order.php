<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orderDetails(){
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }
}
