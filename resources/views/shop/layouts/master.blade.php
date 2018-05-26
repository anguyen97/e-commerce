<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>AShoes</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="{{ asset('shop_assets/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('admin_assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="{{ asset('shop_assets/css/slick.css') }}" />
	<link type="text/css" rel="stylesheet" href="{{ asset('shop_assets/css/slick-theme.css') }}" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="{{ asset('shop_assets/css/nouislider.min.css') }}" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="{{ asset('shop_assets/css/font-awesome.min.css') }}">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="{{ asset('shop_assets/css/style.css') }}" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	@yield('css')
	<style>
	#modalDetails{
		padding-top: 50px;
	}
</style>

</head>

<body>
	<!-- HEADER -->
	<header>
		<!-- top Header -->
		<div id="top-header">
			<div class="container">
				<div class="pull-left">
					<span>Welcome to AShoes!</span>
				</div>
				<div class="pull-right">
					<ul class="header-top-links">
						<li><a href="{{ route('shop.home') }}">Store</a></li>
						<li><a href="#">Newsletter</a></li>
						<li><a href="#">FAQ</a></li>
						<li class="dropdown default-dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">ENG <i class="fa fa-caret-down"></i></a>
							<ul class="custom-menu">
								<li><a href="#">English (ENG)</a></li>
								<li><a href="#">Russian (Ru)</a></li>
								<li><a href="#">French (FR)</a></li>
								<li><a href="#">Spanish (Es)</a></li>
							</ul>
						</li>
						<li class="dropdown default-dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">USD <i class="fa fa-caret-down"></i></a>
							<ul class="custom-menu">
								<li><a href="#">USD ($)</a></li>
								<li><a href="#">EUR (€)</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- /top Header -->

		<!-- header -->
		<div id="header">
			<div class="container">
				<div class="pull-left">
					<!-- Logo -->
					<div class="header-logo">
						<a class="logo" href="{{ route('shop.home') }}">
							<img src="{{ asset('shop_assets/img/logo.png') }}" alt="">
						</a>
					</div>
					<!-- /Logo -->

					<!-- Search -->
					<div class="header-search">
						<form>
							<input class="input search-input" type="text" placeholder="Enter your keyword">
							<select class="input search-categories">
								<option value="0">Search</option>
							</select>
							<button class="search-btn"><i class="fa fa-search"></i></button>
						</form>
					</div>
					<!-- /Search -->
				</div>
				<div class="pull-right">
					<ul class="header-btns">
						<!-- Account -->
						<li class="header-account dropdown default-dropdown">
							<div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
								<div class="header-btns-icon">
									<i class="fa fa-user-o"></i>
								</div>
								<strong class="text-uppercase">My Account <i class="fa fa-caret-down"></i></strong>
							</div>
							<a href="{{ route('login') }}" class="text-uppercase">Login</a> / <a href="#" class="text-uppercase">Join</a>
							<ul class="custom-menu">
								<li><a href="#"><i class="fa fa-user-o"></i> My Account</a></li>
								<li><a href="#"><i class="fa fa-heart-o"></i> My Wishlist</a></li>
								<li><a href="#"><i class="fa fa-exchange"></i> Compare</a></li>
								<li><a class="checkout" ><i class="fa fa-check"></i> Checkout</a></li>
								<li><a href="#"><i class="fa fa-unlock-alt"></i> Login</a></li>
								<li><a href="#"><i class="fa fa-user-plus"></i> Create An Account</a></li>
							</ul>
						</li>
						<!-- /Account -->

						<!-- Cart -->
						<li class="header-cart dropdown default-dropdown">
							<a aria-expanded="true" id="cart" href="{{ route('getCart') }}">
								<div class="header-btns-icon">
									<i class="fa fa-shopping-cart"></i>
									{{-- <span class="qty" id="cart-qty">0</span> --}}
								</div>
								<strong class="text-uppercase">My Cart:</strong>
								<br>
								{{-- <span id="cart-total">$</span> --}}
							</a>
						</li>
						<!-- /Cart -->

						<!-- Mobile nav toggle-->
						<li class="nav-toggle">
							<button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
						</li>
						<!-- / Mobile nav toggle -->
					</ul>
				</div>
			</div>
			<!-- header -->
		</div>
		<!-- container -->
	</header>
	<!-- /HEADER -->

	<!-- NAVIGATION -->
	<div id="navigation">
		<!-- container -->
		<div class="container">
			<div id="responsive-nav">
				<!-- category nav -->
				<div class="category-nav show-on-click">
					<span class="category-header">Categories <i class="fa fa-list"></i></span>
					<ul class="category-list">
						@foreach ($category_list as $category)
						<li><a href="{{ asset('') }}category/{{$category->slug}}">{{$category->name}}</a></li>
						@endforeach
					</ul>
				</div>
				<!-- /category nav -->

				<!-- menu nav -->
				<div class="menu-nav">
					<span class="menu-header">Menu <i class="fa fa-bars"></i></span>
					<ul class="menu-list">
						<li><a href="{{ route('shop.home') }}">Home</a></li>
						<li  class="dropdown default-dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Brand <i class="fa fa-caret-down"></i></a>
							<ul class="custom-menu">
								@foreach ($brand_list as $brand)
								<li><a href="{{ asset('') }}brand/{!!$brand->slug!!}">{{$brand->name}}</a></li>
								@endforeach								
							</ul>
						</li>
						<li><a href="#">Sales</a></li>
						<li><a href="{{ route('all-item') }}">All item</a></li>
						<li class="dropdown default-dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Pages <i class="fa fa-caret-down"></i></a>
							<ul class="custom-menu">
								<li><a href="{{ route('shop.home') }}">Home</a></li>
								<li><a href="products.html">Products</a></li>
								<li><a href="product-page.html">Product Details</a></li>
								<li><a href="checkout.html">Checkout</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<!-- menu nav -->
			</div>
		</div>
		<!-- /container -->
	</div>
	<!-- /NAVIGATION -->

	@yield('home')

	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">

				@yield('content')

			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

	<!-- FOOTER -->
	<footer id="footer" class="section section-grey">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- footer widget -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						<!-- footer logo -->
						<div class="footer-logo">
							<a class="logo" href="#">
								<img src="{{ asset('shop_assets/img/logo.png') }}" alt="">
							</a>
						</div>
						<!-- /footer logo -->

						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</p>

						<!-- footer social -->
						<ul class="footer-social">
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-instagram"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
						</ul>
						<!-- /footer social -->
					</div>
				</div>
				<!-- /footer widget -->

				<!-- footer widget -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						<h3 class="footer-header">My Account</h3>
						<ul class="list-links">
							<li><a href="#">My Account</a></li>
							<li><a href="#">My Wishlist</a></li>
							<li><a href="#">Compare</a></li>
							<li><a href="#">Checkout</a></li>
							<li><a href="#">Login</a></li>
						</ul>
					</div>
				</div>
				<!-- /footer widget -->

				<div class="clearfix visible-sm visible-xs"></div>

				<!-- footer widget -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						<h3 class="footer-header">Customer Service</h3>
						<ul class="list-links">
							<li><a href="#">About Us</a></li>
							<li><a href="#">Shiping & Return</a></li>
							<li><a href="#">Shiping Guide</a></li>
							<li><a href="#">FAQ</a></li>
						</ul>
					</div>
				</div>
				<!-- /footer widget -->

				<!-- footer subscribe -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						<h3 class="footer-header">Stay Connected</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
						<form>
							<div class="form-group">
								<input class="input" placeholder="Enter Email Address">
							</div>
							<button class="primary-btn">Join Newslatter</button>
						</form>
					</div>
				</div>
				<!-- /footer subscribe -->
			</div>
			<!-- /row -->
			<hr>
			<!-- row -->
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center">
					<!-- footer copyright -->
					<div class="footer-copyright">
						<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Design <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="" target="_blank">Anh Nguyen Trung</a>
						<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					</div>
					<!-- /footer copyright -->
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</footer>
	<!-- /FOOTER -->


	{{-- CART DETAILS --}}
	{{-- <div class="modal fade" id="modalDetails">
		<div class="container">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">CART'S DETAILS</h4>
				</div>
				<div class="modal-body">
					<table class="table table-hover table-bordered" id="tblCartDetails">
						<thead>
							<tr>
								<th width="5%" class="text-center">#</th>
								<th class="text-center">Thumbnail</th>
								<th class="text-center">Name</th>
								<th class="text-center">Brand</th>
								<th class="text-center">Category</th>
								<th class="text-center">Color</th>
								<th class="text-center">Size</th>
								<th class="text-center">Quantity</th>
								<th class="text-center">Subtotal</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div> --}}

	<div class="modal fade" id="modalCheckOut">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Checkout</h4>
				</div>
				<div class="modal-body">
					<form action="{{ route('checkout') }}" method="POST" role="form">
						@csrf
						<div class="form-group">
							<label for="">Name</label>
							<input type="text" class="form-control" id="name" name="name">
						</div>
						<div class="form-group">
							<label for="">Email</label>
							<input type="email" class="form-control" id="email" name="email">
						</div>
						<div class="form-group">
							<label for="">Phone</label>
							<input type="text" class="form-control" id="mobile" name="mobile">
						</div>
						<div class="form-group">
							<label for="">Adress</label>
							<input type="text" class="form-control" id="address" name="address">
						</div>

						
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div>
				
			</div>
		</div>
	</div>

	<!-- jQuery Plugins -->
	<script src="{{ asset('shop_assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('shop_assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('admin_assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('admin_assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('shop_assets/js/slick.min.js') }}"></script>
	<script src="{{ asset('shop_assets/js/nouislider.min.js') }}"></script>
	<script src="{{ asset('shop_assets/js/jquery.zoom.min.js') }}"></script>
	<script src="{{ asset('shop_assets/js/main.js') }}"></script>

	

	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
	@yield('js')
	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
	{{-- <script>
		$(function() {
			$('#cart').on('click', function() {
				event.preventDefault();
				$('#modalDetails').modal('show');
				$('#tblCartDetails').DataTable({
					processing: true,
					serverSide: true,
					destroy: true,
					ajax: '{{ route('getCart') }}',
					columns: [
					{ data: 'id', name: 'id' },
					{ data: 'thumbnail', name: 'thumbnail', render: function(row, data, index){
						return '<img src=\"http://ashoes.com/'+data.thumbnail+'" alt="" height="80px">'}
					},
					{ data: 'name', name: 'name' },
					{ data: 'brand', name: 'brand' },
					{ data: 'category', name: 'category' },
					{ data: 'code', name: 'code', render: function(row, data, index){
						return $('td', row).eq(4).css('bgcolor', data);}
					},
					{ data: 'size', name: 'size' },
					{ data: 'quantity', name: 'qty' },
					{ data: 'sub-total', name: 'subtotal' },
					]
				})
			})
		})
	</script> --}}
	<script>
		$(function() {
			$('.checkout').on('click', function(event) {
				event.preventDefault();
				$('#modalCheckOut').modal('show');
			});
		})
	</script>
</body>

</html>
