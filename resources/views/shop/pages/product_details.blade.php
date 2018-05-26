@extends('shop.layouts.master')

@section('content')
<!-- BREADCRUMB -->
<div id="breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li><a href="#">Products</a></li>
			<li class="active">{!!$product->name!!}</li>
		</ul>
	</div>
</div>
<!-- /BREADCRUMB -->

<!-- section -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<!--  Product Details -->
			<div class="product product-details clearfix">
				<div class="col-md-6">
					<div id="product-main-view">
						@foreach ($product['gallery'] as $image)
						<div class="product-view">
							<img src="http://ashoes.com/{{$image['link']}}" alt="">
						</div>
						@endforeach
						
					</div>
					<div id="product-view">
						@foreach ($product['gallery'] as $image)
						<div class="product-view">
							<img src="http://ashoes.com/{{$image['link']}}" alt="">
						</div>	
						@endforeach					
					</div>
				</div>
				<div class="col-md-6">
					<div class="product-body">
						{{-- <div class="product-label">
							<span>New</span>
							<span class="sale">-20%</span>
						</div> --}}
						<h2 class="product-name">{!!$product->name!!}</h2>
						<input type="hidden" name="product-id" value="{!!$product->id!!}" id="product-id">
						<h3 class="product-price">$ {!!$product->sale_price!!}
							<del class="product-old-price">
								@if ($product->origin_price != $product->sale_price)
								$ {!!$product->origin_price!!}
								@endif
							</del>
						</h3>
						<div>
							<div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star-o empty"></i>
							</div>
							<a href="#">3 Review(s) / Add Review</a>
						</div>

						<p><strong>Brand:</strong> {!!$product->brand!!}</p>
						<p>{!!$product->description!!}</p>
						<div class="product-options">
							<ul class="size-option">
								<li><span class="text-uppercase">Size:</span></li>
								@foreach ($product['sizes'] as $key=> $size)
								@if ($key==0)
								<li class="active size-active size" id="size-{!!$size->id!!}" data-size-id="{!!$size->id!!}">
									<a class="selectSize" data-id="{!!$size->id!!}">{!!$size->size!!}</a>
								</li>
								@else
								<li id="size-{!!$size->id!!}" class="size" data-size-id="{!!$size->id!!}">
									<a class="selectSize" data-id="{!!$size->id!!}">{!!$size->size!!}</a>
								</li>
								@endif								
								@endforeach
							</ul>
							<ul class="color-option">
								<li><span class="text-uppercase">Color:</span></li>
								@foreach ($product['colors'] as $key => $color)
								@if ($key==0)
								<li class="active color-active color" id="color-{!!$color->id!!}" data-color-id="{!!$color->id!!}">
									<a style="background-color:{!!$color->code!!}; border:1px solid grey" class="selectColor" data-id="{!!$color->id!!}"></a>
								</li>
								@else
								<li id="color-{!!$color->id!!}" class="color" data-color-id="{!!$color->id!!}">
									<a style="background-color:{!!$color->code!!}; border:1px solid grey" class="selectColor" data-id="{!!$color->id!!}"></a>
								</li>
								@endif
								@endforeach

							</ul>
						</div>

						<div class="product-btns">
							<div class="qty-input">
								<span class="text-uppercase">QTY: </span>
								<input class="quantity input" type="number" min="1" max="" required="" id="quantity">								
							</div>
							<div class="clearfix" style="height: 10px"></div>

							{{-- <button class="primary-btn add-to-cart" id="add2cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button> --}}
							<div class="pull-right">
								<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
								<button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button>
								<button class="main-btn icon-btn"><i class="fa fa-share-alt"></i></button>
							</div>
							<form action="" method="POST" role="form">
								@csrf
								<button class="primary-btn add-to-cart" id="add2cart" type="submit"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="product-tab">
						<ul class="tab-nav">
							<li class="active"><a data-toggle="tab" href="#tab1">Details</a></li>

							<li><a data-toggle="tab" href="#tab2">Reviews (3)</a></li>
						</ul>
						<div class="tab-content">
							<div id="tab1" class="tab-pane fade in active">
								{!!$product->content!!}
							</div>
							<div id="tab2" class="tab-pane fade in">

								<div class="row">
									<div class="col-md-6">
										<div class="product-reviews">
											<div class="single-review">
												<div class="review-heading">
													<div><a href="#"><i class="fa fa-user-o"></i> John</a></div>
													<div><a href="#"><i class="fa fa-clock-o"></i> 27 DEC 2017 / 8:0 PM</a></div>
													<div class="review-rating pull-right">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o empty"></i>
													</div>
												</div>
												<div class="review-body">
													<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute
													irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
												</div>
											</div><ul class="reviews-pages">
												<li class="active">1</li>
												<li><a href="#">2</a></li>
												<li><a href="#">3</a></li>
												<li><a href="#"><i class="fa fa-caret-right"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="col-md-6">
										<h4 class="text-uppercase">Write Your Review</h4>
										<p>Your email address will not be published.</p>
										<form class="review-form">
											<div class="form-group">
												<input class="input" type="text" placeholder="Your Name" />
											</div>
											<div class="form-group">
												<input class="input" type="email" placeholder="Email Address" />
											</div>
											<div class="form-group">
												<textarea class="input" placeholder="Your review"></textarea>
											</div>
											<div class="form-group">
												<div class="input-rating">
													<strong class="text-uppercase">Your Rating: </strong>
													<div class="stars">
														<input type="radio" id="star5" name="rating" value="5" /><label for="star5"></label>
														<input type="radio" id="star4" name="rating" value="4" /><label for="star4"></label>
														<input type="radio" id="star3" name="rating" value="3" /><label for="star3"></label>
														<input type="radio" id="star2" name="rating" value="2" /><label for="star2"></label>
														<input type="radio" id="star1" name="rating" value="1" /><label for="star1"></label>
													</div>
												</div>
											</div>
											<button class="primary-btn">Submit</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<!-- /Product Details -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /section -->

{{-- @if (session('error'))
    <div class="alert alert-success">
        {{ session('error') }}
    </div>
@endif --}}

@endsection

@section('js')
<script>

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(function() {
		$('.selectColor').on('click', function(event) {
			event.preventDefault();
			var id = $(this).data('id');
			var active = document.getElementsByClassName('color-active')[0];
			
			$(active).removeClass('active color-active');
			var click = document.getElementById('color-'+id);
			$(click).addClass('active color-active');
		});
	})

	$(function() {
		$('.selectSize').on('click', function(event) {
			event.preventDefault();
			var id = $(this).data('id');
			var active = document.getElementsByClassName('size-active')[0];
			
			$(active).removeClass('active size-active');
			var click = document.getElementById('size-'+id);
			$(click).addClass('active size-active');
		});
	})

	$(function() {
		$('#add2cart').on('click', function(event) {
			event.preventDefault();
			$.ajax({
				url: '{{ route('add2cart') }}',
				type: 'POST',
				data: {
					product_id: $('#product-id').val(),
					size_id: $('.size-active').data('size-id'),
					color_id: $('.color-active').data('color-id'),
					quantity: $('#quantity').val(),
				},
				success: function(res) {
					toastr['success']('New item added to cart!');
					console.log(res);
					$('#cart-total').text(res.total);
					$('#cart-qty').text(res.qty);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					toastr['error']('Product: Out of stock ...');
				}
			})
		});
	})
	
</script>
@endsection