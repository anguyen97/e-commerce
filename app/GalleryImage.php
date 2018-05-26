<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = ['product_id' ,'link'];

    protected $table = 'gallery_image';
}
