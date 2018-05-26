<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
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

class OrderController extends Controller
{
    /**
	 * display brand page
	 * @return [type] [description]
	 */
    public function getIndex()
    {
    	return view('admin.orders.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
    	// return Datatables::of(Order::query())
    	// ->addColumn('action', function ($order) {
    	// 	return '<a title="Detail" href="http://ashoes.com/admin/orders/listProduct/'.$order["id"].'" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'.$order["id"].'" id="row-'.$order["id"].'"></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='.$order["id"].'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='.$order["id"].'></a>';
    	// })
    	// ->setRowId('id')
    	// ->make(true);


    	return Datatables::of(Order::query())
    	->addColumn('action', function ($order) {
    		return '<a title="Detail" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'.$order["id"].'" id="row-'.$order["id"].'"></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='.$order["id"].'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='.$order["id"].'></a>';
    	})
    	->setRowId('id')
    	->make(true);
    }


    public function anyDataProduct($id)
    {
    	$list_pro = [];
    	$list_product_details_id = OrderDetails::where('order_id','=',$id)->get();
    	// dd($list_product_details_id);
    	foreach ($list_product_details_id as $item) {
    		// $product_detail_id = $item['product_detail_id'];
// dd($item);
    		$product_id = ProductDetails::where('id','=', $item['product_detail_id'])->first()['product_id'];
    		$product = Product::find($product_id);
    		$product_detail = ProductDetails::where('id','=', $item['product_detail_id'])->first();

    		// dd($product);
    		// dd($product_detail);
    		$size = Size::find($product_detail['size_id'])->first()['size'];
    		$color = Color::find($product_detail['color_id'])->first()['code'];
    		// $list = Product::whereIn('id', $list_product_id)->get();
    		$item['name'] = $product['name'];
    		$item['brand'] = Brand::find($product['brand_id'])['name'];
    		$item['category'] = Category::find($product['category_id'])['name'];
    		$thumbnail = GalleryImage::where('product_id','=', $product['id'])->first();
    		if (!$thumbnail) {
    			$item['thumbnail'] = 'storage/products/shoes_default.png';
    		} else {
    			$item['thumbnail'] = $thumbnail['link'];
    		}
    		$item['size'] =$size;
    		$item['color'] = $color;
    		// dd($item);
    		$list_pro[] = $item;
    		
    	}    	
    	// dd($list_pro);
    	return Datatables::of($list_pro)
    	->setRowId('id')
    	->make(true);
    }

}
