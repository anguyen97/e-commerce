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

class ProductController extends Controller
{
    /**
	 * display brand page
	 * @return [type] [description]
	*/
    public function getIndex()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.index',[
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
    	$list = Product::all();
        foreach ($list as $item) {
            $item['brand'] = Brand::find($item['brand_id'])['name'];
            $item['category'] = Category::find($item['category_id'])['name'];
            $thumbnail = GalleryImage::where('product_id','=', $item['id'])->first();
            if ($thumbnail==false) {
                $item['thumbnail'] = 'storage/products/shoes_default.png';
            } else {
                $item['thumbnail'] = $thumbnail['link'];
            }
        }
        return Datatables::of($list)
        ->addColumn('action', function ($product) {
            return '<a title="Detail" class="btn btn-success btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'.$product["id"].'" id="row-'.$product["id"].'"></a>&nbsp;<a title="List Product" class="btn btn-info btn-sm glyphicon glyphicon-list-alt btnList" data-id='.$product["id"].'></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='.$product["id"].'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='.$product["id"].'></a>';
        })
        ->setRowId('id')
        ->make(true);
    }

    /**
     * display view add new product
     * @return [type] [description]
     */
    public function getAddForm()
    {
        return view('admin.products.create');
    }


    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);

        //save new size to db
        $sizes = Size::storeData($data);

        //save new color to db
        $colors = Color::storeData($data);

        //process quantity
        $quantity = [];
        foreach ($data as $key => $value) {
            if(str_contains($key, 'quantity')){
                $quantity [] = $value;
            }
        }

        // $rules = [
        //     'name' => 'required',
        //     'description' => 'required',
        //     'content' => 'required',
        //     'category_id' => 'required',
        //     'thumbnail' => 'mimes:jpeg,png,jpg',
        // ];

        // $messages = [
        //     'name.required' => 'The name is required!',
        //     'description.required' => 'The description is required!',
        //     'content.required' => 'The content is required!',
        //     'category_id.required' => 'The category is required!',
        //     'thumbnail.mimes' => 'The thumbnail must have extension: (jpg, jpeg, png)!',
        // ];

        // $validator = Validator::make($data, $rules, $messages);

        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator);
        // }

        $product = array(
            'name' => $data['name'], 
            'origin_price' => $data['origin_price'], 
            'sale_price' => $data['sale_price'], 
            'brand_id' => $data['brand'], 
            'category_id' => $data['category'], 
            'description' => $data['description'], 
            'content' => $data['content'], 
            'slug' => str_slug($data['name'], '-'),
        );
        
        $new_product = Product::create($product);

        if (!$new_product) {
            return redirect()->route('admin.product',[
                'error' => 'Add failed!',
            ]);
        } else {

            //save gallery images
            if ($request->hasFile('images')) {

                $date = date('YmdHis', time());

                $images = $request->file('images');

                $gallery_image['product_id'] = $new_product['id'];

                foreach ($images as $image) {
                    $name = $image->getClientOriginalName();

                    $extension = '.'.$image->getClientOriginalExtension();

                    $file_name = md5($request->name.$name).'_'. $date . $extension;

                    $image->storeAs('public/products',$file_name);

                    $gallery_image['link'] = 'storage/products/'.$file_name;

                    GalleryImage::create($gallery_image);
                }

            } else {
                // $data['thumbnail']='storage/products/shoes_default.png';
            }

            //save product_details
            foreach ($colors as $key => $color) {
                $product_details = ['product_id' => $new_product['id'],'color_id'=> $color, 'size_id' => $sizes[$key], 'quantity' => $quantity[$key] ];
                ProductDetails::create($product_details);
            }
            return redirect()->route('admin.product',[
                'success' => 'Add success!',
            ]);
        }
    }


    /**
     * get product information by ID
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        if ($product){
            $product['brand'] = Brand::find($product['brand_id'])['name'];
            $product['category'] = Category::find($product['category_id'])['name'];
            $thumbnail = GalleryImage::where('product_id','=',$product['id'])->first()['link']; 
            if (!$thumbnail) {
                $product['thumbnail'] = 'storage/products/shoes_default.png';
            } else {
                $product['thumbnail'] = $thumbnail;
            }
        }  
        return $product;      
    }

    /**
     * get product details by ID
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getProductDetails($id)  
    {
        $product_list = ProductDetails::where('product_id', '=', $id)
        ->join('colors', 'product_details.color_id','=','colors.id')
        ->join('sizes', 'product_details.size_id', '=', 'sizes.id')
        ->select('product_details.*', 'colors.code', 'sizes.size')
        ->get();

        $infor = Product::find($id);
        $category = Category::find($infor['category_id']);
        $brand = Brand::find($infor['brand_id']);

        foreach ($product_list as $item) {
            $item['name'] = $infor['name'];
            $item['brand'] = $brand['name'];
            $item['category'] = $category['name'];
        }
        return Datatables::of($product_list)
        ->setRowId('id')
        ->make(true);
    }

    /**
     * delete product by id
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
        $res = Product::find($id)->delete();
        if ($res==true) {
            return response(['success'], 200);
        } else {
            return response([],400);
        }       
    }
}
