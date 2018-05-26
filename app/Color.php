<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Color;

class Color extends Model
{
    protected $fillable = ['color', 'code'];

    protected $table = 'colors';

    /**
     * save new color when add new product 
     * @param  [type] $data [description]
     * @return array of color_id which are in collection of new product
     */
    public static function storeData($data)	
    {
        $colors = [];
    	foreach ($data as $key => $value) {
    		if(str_contains($key, 'color')){
    			$color_exist = Color::where('code','=',$value)->first();
    			if (!$color_exist) {    				
    				$newColor = Color::create(['code'=>$value]);
                    $colors [] = $newColor['id'];
    			} else {
                    $colors[] = $color_exist['id'];
                }                
    		}
    	}
        // dd($colors);
    	return $colors;
    }
}
