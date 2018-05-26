<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'origin_price', 'sale_price', 'description', 'content', 'slug', 'brand_id', 'provider_id', 'category_id'];

    protected $table= 'products';

    // public function brand()
    // {
    // 	return $this->belongsTo('App\Brand');
    // }

    // public function product_detail()
    // {
    // 	return $this->hasOne('App\ProductDetails');
    // }

    // public function sizes()
    // {
    // 	return $this->hasManyThrough('App\ProductDetails', 'App\Size');
    // }

    // public function colors()
    // {
    // 	return $this->hasManyThrough('App\ProductDetails', 'App\Color');
    // }

}
