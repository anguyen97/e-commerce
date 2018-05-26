<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Brand;
use App\Category;
use App\Product;
use App\ProductDetails;
use App\Order;
use App\OrderDetails;
use App\GalleryImage;
use App\Color;
use App\Size;
use App\User;

class HomeController extends Controller
{
    public function getIndex()
    {
    	$brand_list = Brand::all();
    	$category_list = Category::all();

    	$lastest_product = Product::orderBy('created_at', 'desc')->take(8)->get();
    	foreach ($lastest_product as $item) {
    		$thumbnail = GalleryImage::where('product_id', '=', $item['id'])->first()['link'];
            if ($thumbnail) {
                $item['thumbnail'] = $thumbnail;
            } else {
                $item['thumbnail'] = 'storage/products/shoes_default.png';
            }
    	}

        

    	return view('shop.index',[
    		'brand_list' => $brand_list,
    		'category_list' => $category_list,
    		'lastest_product' => $lastest_product,
    	]);
    }
}
