<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Product;
use App\ProductDetails;
use App\Category;
use App\Brand;
use App\GalleryImage;
use App\Size;
use App\Color;

class ColorController extends Controller
{
   /**
	 * display color page
	 * @return [type] [description]
	 */
   public function getIndex()
   {
   	return view('admin.colors.index');
   }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
    	return Datatables::of(Color::query())
    	->addColumn('action', function ($color) {
    		return '<a title="Detail" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'.$color["id"].'" id="row-'.$color["id"].'"></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='.$color["id"].'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='.$color["id"].'></a>';
    	})
    	->setRowId('id')
    	->make(true);
    }

    /**
     * save new color to db
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
    	$data = $request->all();
    	$exist = Color::where('code','=',$data['code'])->first();
    	if (!$exist) {
    		return Color::create($data);
    	} else {
    		return response($content = 'error', $status = 400);
    	}
    	
    }

    /**
     * get color's infomation and display to edit
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
    	return Color::find($id);
    }

    /**
     * update color by id
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request,$id)
    {
    	$data = $request->all();
    	$exist = Color::where('color','=',$data['color'])->first();
    	if ($exist) {
    		return response($content = 'error', $status = 400);
    	}
    	$res = Color::find($id)->update($data);
    	if($res ==true){
    		return Color::find($id);
    	} else {
    		return response([],400);
    	}
    }

    /**
     * delete color by id
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
        // $color = color::find($id)->first();
    	$list = ProductDetails::where('color_id', '=', $id)->get();
    	if ($list) {
    		foreach ($list as $item) {
    			ProductDetails::find($item['id'])->delete();
    		}
    	}
    	$res = Color::find($id)->delete();
    	if ($res==true) {
    		return response(['success'], 200);
    	} else {
    		return response([],400);
    	}    	
    }


    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyDataProductByColor($id)
    {
    	$list_product_id = ProductDetails::where('color_id', '=', $id)->select('product_id')->get();
    	$list = Product::whereIn('id', $list_product_id)->get();
    	foreach ($list as $item) {
    		$item['brand'] = Brand::find($item['brand_id'])['name'];
    		$item['category'] = Category::find($item['category_id'])['name'];
    		$thumbnail = GalleryImage::where('product_id','=', $item['id'])->first();
    		if (!$thumbnail) {
    			$item['thumbnail'] = 'storage/products/shoes_default.png';
    		} else {
    			$item['thumbnail'] = $thumbnail['link'];
    		}
    	}
    	return Datatables::of($list)
    	->setRowId('id')
    	->make(true);
    }
}
