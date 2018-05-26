<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Size;

class Size extends Model
{
    protected $fillable = ['size'];

    protected $table = 'sizes';

    /**
     * save new size to db
     * @param  [type] $data [description]
     * @return array of size_id which in collection of new product
     */
    public static function storeData($data)
    {
        $sizes = [];
        foreach ($data as $key => $value) {

            if(str_contains($key, 'size')){
                $size_exist = Size::where('size','=',$value)->first();
                if (!$size_exist) {
                    $new_size = Size::create(['size'=>$value]);
                    $sizes[] = $new_size['id'];
                    
                } else {
                    $sizes[] = $size_exist['id'];
                }
            }
        }
        // dd($sizes);
        return $sizes;
    }
}
