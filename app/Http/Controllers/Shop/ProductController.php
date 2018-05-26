<?php

namespace App\Http\Controllers\Shop;

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

class ProductController extends Controller
{

	/**
	 * get product detail and display
	 * @param  [type] $slug [description]
	 * @return [type]       [description]
	 */
	public function product_details($slug)
	{

		$product = Product::where('slug', '=', $slug)->first();
		$product['gallery'] = GalleryImage::where('product_id', '=', $product['id'])->select('link')->get();
		$product['brand'] = Brand::find($product['brand_id'])['name'];
		$product['category'] = Category::find($product['category_id'])['name'];
    	// $product['details'] = ProductDetails::where('product_id', '=', $product['id'])
    	// ->join('colors', 'product_details.color_id', '=', 'colors.id')
    	// ->join('sizes', 'product_details.size_id', '=', 'sizes.id')
    	// ->select('product_details.quantity', 'sizes.size', 'sizes.id', 'colors.id', 'colors.code')
    	// ->get();
		$colors = ProductDetails::where('product_id','=', $product['id'])->select('color_id')->get();
		$product['colors'] = Color::whereIn('id', $colors)->select('id', 'code')->get();

		$sizes = ProductDetails::where('product_id','=', $product['id'])->select('size_id')->get();
		$product['sizes'] = Size::whereIn('id', $sizes)->select('size', 'id')->orderBy('size','asc')->get();
		// dd($product);
		$brand_list = Brand::all();
		$category_list = Category::all();
		return view('shop.pages.product_details',[
			'brand_list' => $brand_list,
			'category_list' => $category_list,
			'product' => $product,
		]);
	}

	/**
	 * add product to cart
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function add2cart(Request $request)
	{
		$data = $request->all();
		$pro_details = ProductDetails::where([
			['product_id', '=', $data['product_id']],
			['size_id','=', $data['size_id']],
			['color_id','=', $data['color_id']],
		])->first();

		$id_product_details = $pro_details['id'];

		//get all product in cart
		$rows = \Cart::content();
		/**
		 * $rows : COLLECTION type
		 * $cartItem: call item in Collection
		 * $rowId: field returned, use($id): using $id to be parameter
		 * @var [type]
		 */
		$rowId = $rows->search(function($cartItem, $rowId) use($id_product_details) {
			return ($cartItem->id == $id_product_details);
		});

		$product = Product::find($data['product_id']);

		if ($rowId!=false) {  
			
			$item = \Cart::get($rowId);
			
			return \Cart::update($rowId, $item->qty+$data['quantity']);

		} else {
			$new_item =  \Cart::add($pro_details['id'], $product['name'], $data['quantity'], $product['sale_price']);
			if ($new_item) {
				return response()->json([
					'new_item' => $new_item,
					'total' => \Cart::total(),
					'qty' => \Cart::count(),
				]);
			} else {
				return $new_item;
			}
		}  
	}

	/**
	 * get list product by category
	 * @param  [type] $id [description]
	 * @return view
	 */
	public function getProductByCategory($slug)
	{
		$brand_list = Brand::all();
		$category_list = Category::all();

		$cate = Category::where('slug','=',$slug)->first();

		$list = Product::where('category_id','=',$cate['id'])->paginate(8);
		foreach ($list as $item) {
			$thumbnail = GalleryImage::where('product_id', '=', $item['id'])->first()['link'];
			if ($thumbnail) {
				$item['thumbnail'] = $thumbnail;
			} else {
				$item['thumbnail'] = 'storage/products/shoes_default.png';
			}
		}

    	// dd($list);
		return view('shop.pages.filterByCategory',[
			'brand_list' => $brand_list,
			'category_list' => $category_list,
			'list_product' => $list,
			'cate' => $cate,
		]);
	}

	/**
	 * get list product by brand
	 * @param  [type] $id [description]
	 * @return view
	 */
	public function getProductByBrand($slug)
	{
		$brand_list = Brand::all();
		$category_list = Category::all();

		$brand = Brand::where('slug','=',$slug)->first();

		$list = Product::where('brand_id','=',$brand['id'])->paginate(8);
		foreach ($list as $item) {
			$thumbnail = GalleryImage::where('product_id', '=', $item['id'])->first()['link'];
			if ($thumbnail) {
				$item['thumbnail'] = $thumbnail;
			} else {
				$item['thumbnail'] = 'storage/products/shoes_default.png';
			}
		}

    	// dd($list);
		return view('shop.pages.filterByBrand',[
			'brand_list' => $brand_list,
			'category_list' => $category_list,
			'list_product' => $list,
			'brand' => $brand,
		]);
	}

	/**
	 * get cart infor
	 * @return [type] [description]
	 */
	public function getCart()
	{
		$rows =  \Cart::content();

		foreach ($rows as $item) {
			// dd($item->id);
			$product_detail = ProductDetails::find($item->id);
			$product_id = $product_detail['product_id'];
			$product = Product::find($product_id)->first();
			$item->thumbnail = GalleryImage::where('product_id', '=', $product_id)->first()['link'];
			$item->brand = Brand::find($product['brand_id'])['name'];
			$item->category = Category::find($product['category_id'])['name'];
			$item->size = Size::find($product_detail['size_id'])['size'];
			$item->color = Color::find($product_detail['color_id'])['code'];
		}
		$brand_list = Brand::all();
		$category_list = Category::all();
		return view('shop.pages.cart',[
			'cart' => $rows,
			'brand_list' => $brand_list,
			'category_list' => $category_list,
			'tax' =>\Cart::tax(),
			'total' =>\Cart::total(),
		]);
	}


	public function checkout(Request $request)
	{
		$data = $request->all();
		$user_info = User::where('email','=',$data['email'])->first();

		if (!$user_info) {
			$user_name = explode('@',$data['email'])[0];
			
			$user = array(
				'name' =>$data['name'],
				'email' =>$data['email'],
				'phone' =>$data['mobile'],
				'address' =>$data['address'],
				'avatar' =>'storage/user_profile/userDefault.png',
				'password' => \Hash::make($user_name),
			);
			$user_info = User::create($user);
		}		
		
		$rows = \Cart::content();
		$date = date('YmdHis', time());
		if ($rows->count()!=0) {
			$data_order = array(
				'name' => $data['name'],
				'address' => $data['address'],
				'mobile' => $data['mobile'],
				'user_id' => $user_info['id'],
				'total_price' => \Cart::total(),
				'code' => 'ASHOES'.$date,
				'status' => '1',
			);

			$order_info = Order::create($data_order);
			
			foreach ($rows as $item) {
				$data =[
					'order_id' => $order_info['id'],
					'product_detail_id' => $item->id,
					'quantity' => $item->qty,
				];
				OrderDetails::create($data);
				$old_qty =  ProductDetails::find($item->id)['quantity'];
				$data = array(
					'quantity' => $old_qty - $item->qty,
				);
				ProductDetails::find($item->id)->update($data);
			}
		}
		\Cart::destroy();
		return redirect()->route('shop.home');
	}


	/**
	 * increase quantity of food/ drink
	 * @param  Request $request [description]
	 * @return food/drink has been updated
	 */
	public function increase($rowId)
	{		
		$item = \Cart::get($rowId);	

		$product_detail = ProductDetails::find($item->id);
		$product_id = $product_detail['product_id'];
		$product = Product::find($product_id)->first();

		$thumbnail = GalleryImage::where('product_id', '=', $product_id)->first()['link'];
		$brand = Brand::find($product['brand_id'])['name'];
		$category = Category::find($product['category_id'])['name'];
		$size = Size::find($product_detail['size_id'])['size'];
		$color = Color::find($product_detail['color_id'])['code'];

		return array(
			'item'=> \Cart::update($rowId,  [
				'qty'=>$item->qty+1,
				'thumbnail' => $thumbnail,
				'brand' => $brand,
				'category' => $category,
				'size' => $size,
				'color' => $color,
			]),
			'total'=> \Cart::total(),
			'tax' =>\Cart::tax()
		);
	}

	/**
	 * decrease quantity of food/ drink
	 * @param  Request $request [description]
	 * @return food/drink has been updated
	 */
	public function decrease($rowId)
	{		
		$item = \Cart::get($rowId);
		if ($item->qty==1) {
			return array(
				'item'=>\Cart::remove($rowId),
				'total' => \Cart::total(),
				'tax' => \Cart::tax(),
			);
		} else {
			$product = Product::find($item->id);	
			return array(
				'item'=> \Cart::update($rowId,  [
					'qty'=>$item->qty-1,
					'thumbnail' => $product['thumbnail'],
					'origin_price' =>$product['origin_price']
				]),
				'total'=> \Cart::total(),
				'tax' =>\Cart::tax()
			);
		}		
	}


	public function getAllItemPage()
	{
		$brand_list = Brand::all();
		$category_list = Category::all();
		$product_list  = Product::paginate(8);
		foreach ($product_list as $item) {
			$thumbnail = GalleryImage::where('product_id', '=', $item['id'])->first()['link'];
			if ($thumbnail) {
				$item['thumbnail'] = $thumbnail;
			} else {
				$item['thumbnail'] = 'storage/products/shoes_default.png';
			}
		}
		return view('shop.pages.all-item',[
			'brand_list' => $brand_list,
			'category_list' => $category_list,
			'product_list' => $product_list,
		]);
	}
}
