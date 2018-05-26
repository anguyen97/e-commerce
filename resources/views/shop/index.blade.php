@extends('shop.layouts.master')

@section('home')
<!-- container -->
<div class="container">
	<div id="carousel-id" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carousel-id" data-slide-to="0" class=""></li>
			<li data-target="#carousel-id" data-slide-to="1" class=""></li>
			<li data-target="#carousel-id" data-slide-to="2" class="active"></li>
		</ol>
		<div class="carousel-inner">
			<div class="item">
				<img alt="First slide" src="{{ asset('shop_assets/img/banner02.jpg') }}">
				<div class="container">
					<div class="carousel-caption">
						<h1>Example headline.</h1>
						<p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
					</div>
				</div>
			</div>
			<div class="item">
				<img  alt="Second slide" src="{{ asset('shop_assets/img/banner01.jpg') }}">
				<div class="container">
					<div class="carousel-caption">
						<h1>Another example headline.</h1>
						<p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
					</div>
				</div>
			</div>
			<div class="item active">
				<img  alt="Third slide" src="{{ asset('shop_assets/img/banner03.jpg') }}">
				<div class="container">
					<div class="carousel-caption">
						<h1>One more for good measure.</h1>
						<p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
					</div>
				</div>
			</div>
		</div>
		<a class="left carousel-control" href="#carousel-id" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
		<a class="right carousel-control" href="#carousel-id" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
	</div>
</div>
<!-- /container -->
@endsection


@section('content')

<!-- section: 3 hotest brand  -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<!-- banner -->
			<div class="col-md-4 col-sm-6">
				<a class="banner banner-1" href="#">
					<img src="{{ asset('shop_assets/img/banner10.jpg') }}" alt="">
					<div class="banner-caption text-center">
						<h2 class="white-color">NEW COLLECTION</h2>
					</div>
				</a>
			</div>
			<!-- /banner -->

			<!-- banner -->
			<div class="col-md-4 col-sm-6">
				<a class="banner banner-1" href="#">
					<img src="{{ asset('shop_assets/img/banner11.jpg') }}" alt="">
					<div class="banner-caption text-center">
						<h2 class="white-color">NEW COLLECTION</h2>
					</div>
				</a>
			</div>
			<!-- /banner -->

			<!-- banner -->
			<div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-3">
				<a class="banner banner-1" href="#">
					<img src="{{ asset('shop_assets/img/banner12.jpg') }}" alt="">
					<div class="banner-caption text-center">
						<h2 class="white-color">NEW COLLECTION</h2>
					</div>
				</a>
			</div>
			<!-- /banner -->

		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /section -->

<!-- section: Lastest products -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<!-- section title -->
			<div class="col-md-12">
				<div class="section-title">
					<h2 class="title">Latest Products</h2>
				</div>
			</div>
			<!-- section title -->

			<!-- Product Single -->
			@foreach ($lastest_product as $product)
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
			<!-- /Product Single -->
		</div>
		<!-- /row -->

		<!-- row -->
		{{-- <div class="row">
			<!-- banner -->
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="banner banner-2">
					<img src="{{ asset('shop_assets/img/banner15.jpg') }}" alt="">
					<div class="banner-caption">
						<h2 class="white-color">NEW<br>COLLECTION</h2>
						<button class="primary-btn">Shop Now</button>
					</div>
				</div>
			</div>
			<!-- /banner -->

			<!-- Product Single -->
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="product product-single">
					<div class="product-thumb">
						<div class="product-label">
							<span>New</span>
							<span class="sale">-20%</span>
						</div>
						<button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</button>
						<img src="{{ asset('shop_assets/img/product07.jpg') }}" alt="">
					</div>
					<div class="product-body">
						<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
						<div class="product-rating">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-o empty"></i>
						</div>
						<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
						<div class="product-btns">
							<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
							<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
							<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
						</div>
					</div>
				</div>
			</div>
			<!-- /Product Single -->
		</div> --}}
		<!-- /row -->

		<!-- row -->
		{{-- <div class="row">
			<!-- section title -->
			<div class="col-md-12">
				<div class="section-title">
					<h2 class="title">Picked For You</h2>
				</div>
			</div>
			<!-- section title -->

			<!-- Product Single -->
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="product product-single">
					<div class="product-thumb">
						<div class="product-label">
							<span>New</span>
							<span class="sale">-20%</span>
						</div>
						<button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</button>
						<img src="{{ asset('shop_assets/img/product01.jpg') }}" alt="">
					</div>
					<div class="product-body">
						<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
						<div class="product-rating">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-o empty"></i>
						</div>
						<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
						<div class="product-btns">
							<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
							<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
							<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
						</div>
					</div>
				</div>
			</div>
			<!-- /Product Single -->
		</div> --}}
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /section -->

@endsection

@section('js')
<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
</script>
<script>
	$(function() {
		$('.add-to-cart').on('click', function(event) {
			event.preventDefault();
			var pid = $(this).data('pid');
			// alert(pid);
			$.ajax({
				url: 'add2cart/'+pid,
				type: 'GET',
				success: function(res) {
					
				},
				error: function(xhr, ajaxOptions, thrownError) {
					
				}
			})
		});
	})
</script>
@endsection