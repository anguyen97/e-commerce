<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Order;
use App\Product;
use App\ProductDetails;
use App\Category;
use App\Brand;
use App\GalleryImage;
use App\Size;
use App\Color;
use App\OrderDetails;

class NewOrder extends Mailable
{
    use Queueable, SerializesModels;



    public $order_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $order_info = $order; 
        $order_details_info = OrderDetails::where('order_id','=',$order_info['id'])->get();
        foreach ($order_details_info as $item) {
            $pro_detail_id = $item['product_detail_id'];
            $product_detail = ProductDetails::find($pro_detail_id);
            $pro_id = $product_detail['product_id'];
            $product = Product::find($pro_id);
            $item->brand = Brand::find($product['brand_id'])['name'];
            $item->name = $product['name'];
            $item->price = $product['sale_price'];
            $item->category = Category::find($product['category_id'])['name'];
            $item->size = Size::find($product_detail['size_id'])['size'];
            $item->color = Color::find($product_detail['color_id'])['code'];

            // $quantity = $item['quantity'];
            $thumbnail = GalleryImage::where('product_id', '=', $pro_id)->first()['link'];
            if ($thumbnail) {
                $item['thumbnail'] = $thumbnail;
            } else {
                $item['thumbnail'] = 'storage/products/shoes_default.png';
            }
        }
        // dd($order);
        // dd($order_info);
        
        $this->order_details['order_info'] = $order_info;
        $this->order_details['order_details_info'] = $order_details_info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.order.newOrder');
    }
}
