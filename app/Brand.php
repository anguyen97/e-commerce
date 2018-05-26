<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name', 'description', 'country'];

    protected $table= 'brands';

    // public function products()
    // {
    // 	return $this->hasMany('App\Product');
    // }
}
