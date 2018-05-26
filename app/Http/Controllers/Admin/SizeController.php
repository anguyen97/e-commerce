<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Size;
use App\Product;
use App\ProductDetails;
use App\Brand;
use App\GalleryImage;
use App\Category;

class SizeController extends Controller
{
    /**
	 * display size page
	 * @return [type] [description]
	 */
    public function getIndex()
    {
    	return view('admin.sizes.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
    	return Datatables::of(Size::query())
    	->addColumn('action', function ($size) {
    		return '<a title="Detail" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'.$size["id"].'" id="row-'.$size["id"].'"></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='.$size["id"].'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='.$size["id"].'></a>';
    	})
    	->setRowId('id')
    	->make(true);
    }

    /**
     * save new size to db
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
    	$data = $request->all();
    	$exist = Size::where('size','=',$data['size'])->first();
    	if (!$exist) {
    		return Size::create($data);
    	} else {
    		return response($content = 'error', $status = 400);
    	}
    	
    }

    /**
     * get size's info and display
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id)
    {
    	return Size::find($id);
    }

    /**
     * get size's infomation and display to edit
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
    	return Size::find($id);
    }

    /**
     * update size by id
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request,$id)
    {
    	$data = $request->all();
    	$exist = Size::where('size','=',$data['size'])->first();
    	if ($exist) {
    		return response($content = 'error', $status = 400);
    	}
    	$res = Size::find($id)->update($data);
    	if($res ==true){
    		return Size::find($id);
    	} else {
    		return response([],400);
    	}
    }

    /**
     * delete size by id
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
        // $size = Size::find($id)->first();
        $list = ProductDetails::where('size_id', '=', $id)->get();
        if ($list) {
            foreach ($list as $item) {
                ProductDetails::find($item['id'])->delete();
            }
        }
    	$res = Size::find($id)->delete();
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
    public function anyDataProductBySize($id)
    {
    	$list_product_id = ProductDetails::where('size_id', '=', $id)->select('product_id')->get();
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
    	->addColumn('action', function ($size) {
    		return '<a title="Detail" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'.$size["id"].'" id="row-'.$size["id"].'">';
    	})
    	->setRowId('id')
    	->make(true);
    }
}
