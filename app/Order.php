<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['code', 'name', 'address', 'mobile', 'user_id', 'total_price', 'status'];

    protected $table = 'orders';

    // public function order_detail()
    // {
    // 	return $this->hasOne('App\OrderDetails');
    // }

}
