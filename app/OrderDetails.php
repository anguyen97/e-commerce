<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $fillable = ['order_id', 'product_detail_id', 'quantity'];

    protected $table = 'order_details';

    // public function order()
    // {
    // 	return $this->belongsTo('App\Order');
    // }
}
