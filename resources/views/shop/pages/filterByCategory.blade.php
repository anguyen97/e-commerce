@extends('shop.layouts.master')

@section('content')
<!-- BREADCRUMB -->
<div id="breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li><a href="#">Category</a></li>
			<li class="active">{!!$cate['name']!!}</li>
		</ul>
	</div>
</div>
<!-- /BREADCRUMB -->

<!-- section: Lastest products -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<!-- section title -->
			<div class="col-md-12">
				<div class="section-title">
					<h2 class="title">All Products: <span style="color: blue">{!!$cate['name']!!}</span></h2>
				</div>
			</div>
			<!-- section title -->

			@foreach ($list_product as $product)
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="product product-single">
					<div class="product-thumb">
						{{-- <div class="product-label">
							<span>New</span>
							<span class="sale">
								@if ($product->sale_price!=$product->origin_price)
								{{$product['origin_price']/$product['sale_origin']}}
								@endif
							</span>
						</div> --}}
						<button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</button>
						<img src="http://ashoes.com/{{$product['thumbnail']}}" alt="">
					</div>
					<div class="product-body">
						<h3 class="product-price">$ {{$product['sale_price']}}
							<del class="product-old-price">
								@if ($product->sale_price!=$product->origin_price)
								{{$product['origin_price']}}
								@endif
							</del>
						</h3>
						<div class="product-rating">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-o empty"></i>
						</div>
						<h2 class="product-name"><a href="{{ asset('product') }}/{{$product['slug']}}">{{$product['name']}}</a></h2>
						<div class="product-btns">
							<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
							<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
							<a class="primary-btn  btn" href="{{ asset('product') }}/{{$product['slug']}}"><i class="fa fa-bars"></i> More infor</a>
						</div>
					</div>
				</div>
			</div>
			@endforeach
			<div class="clearfix"></div>
			<div class="text-center">
				{{ $list_product->links() }}
			</div>
			
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /section -->

@endsection