@extends('shop.layouts.master')
@section('css')

@endsection
@section('content')
<!-- BREADCRUMB -->
<div id="breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li><a href="#">Your Cart</a></li>
			{{-- <li class="active">{!!$brand['name']!!}</li> --}}
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
					<h2 class="title">All Products: <span style="color: blue"></span></h2>
					<a class="btn btn-success checkout" style="float: right; padding-right: 20px">Checkout</a>
				</div>
			</div>
			<!-- section title -->
			<table class="table table-hover table-bordered" id="tblCart">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Thumbnail</th>
						<th class="text-center">Name</th>
						<th class="text-center">Brand</th>
						<th class="text-center">Category</th>
						<th class="text-center">Color</th>
						<th class="text-center">Size</th>
						<th class="text-center">Quantity</th>
						<th class="text-center">Price</th>
						<th class="text-center">Subtotal</th>
					</tr>
				</thead>
				<tbody>
					
					@foreach ($cart as $rowId => $item)
					<tr id="row-{!!$rowId!!}">
						<td class="text-center">{!!$item->id!!}</td>
						<td class="text-center"><img src="http://ashoes.com/{!!$item->thumbnail!!}" alt="{!!$item->name!!}" style="height: 80px"></td>
						<td>{!!$item->name!!}</td>
						<td>{!!$item->brand!!}</td>
						<td>{!!$item->category!!}</td>
						<td class="text-center"><a style="background-color:{!!$item->color!!}; border:1px solid grey; width: 15px; height: 15px" class="btn"></a></td>
						<td class="text-center">{!!$item->size!!}</td>
						<td class="text-center">
							<a class="btn btn-danger btn-sm btnDecrease" data-id="{!!$rowId!!}"><i class="fa fa-minus"></i></a>
							&nbsp;{!!$item->qty!!}&nbsp;
							<a class="btn btn-success btn-sm btnIncrease" data-id="{!!$rowId!!}"><i class="fa fa-plus"></i></a>
						</td>
						<td class="text-right">{!!$item->price!!}</td>
						<td class="text-right">{!!$item->subtotal!!}</td>
					</tr>

					@endforeach
					
					<tr>
						<td colspan="8" class="text-right"><h3>Tax</h3></td>
						<td colspan="2" class="text-center" id="tblCart-tax">{!!$tax!!}</td>
					</tr>
					<tr>
						<td colspan="8" class="text-right"><h3>Total</h3></td>
						<td colspan="2" class="text-center" id="tblCart-total">{!!$total!!}</td>
					</tr>
				</tbody>
			</table>

		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /section -->

@endsection
@section('js')
<script>
	$('#tblCart').on('click', '.btnIncrease',function(event) {
		event.preventDefault();
		var rowId = $(this).data('id');
		var row = document.getElementById('row-'+rowId);
		// alert(row);
		$.ajax({
			url: '{{ asset('') }}updateCart/increase/'+rowId,
			type: 'GET',			
			success: function(res) {
				toastr['success']('Update quantity successfull!');
				row.remove();
				// alert(res);
				$('#tblCart').prepend('<tr id="row-'+res.item['rowId']+'"><td class="text-center">'+res.item['id']+'</td><td class="text-center"><img src="http://ashoes.com/'+res.item['thumbnail']+'" alt="'+res.item['name']+'" style="height: 80px"></td><td>'+res.item['name']+'</td><td>'+res.item['brand']+'</td><td>'+res.item['category']+'</td><td class="text-center"><a style="background-color:'+res.item['color']+'; border:1px solid grey; width: 15px; height: 15px" class="btn"></a></td><td class="text-center">'+res.item['size']+'</td><td class="text-center"><a class="btn btn-danger btn-sm btnDecrease" data-id="'+res.item['rowId']+'"><i class="fa fa-minus"></i></a>&nbsp;'+res.item['qty']+'&nbsp;<a class="btn btn-success btn-sm btnIncrease" data-id="'+res.item['rowId']+'"><i class="fa fa-plus"></i></a></td><td class="text-right">'+res.item['price']+'</td><td class="text-right">'+res.item['qty']*res.item['price']+'</td></tr>');
				$('#tblCart-total').text(res.total);
				$('#tblCart-tax').text(res.tax);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				toastr['error']('Update quantity failed!');
			}
		})
	});

	$('#tblCart').on('click','.btnDecrease', function(event) {
		event.preventDefault();
		var rowId = $(this).data('id');
		var row = document.getElementById('row-'+rowId);
		// alert(row);
		$.ajax({
			url: '{{ asset('') }}updateCart/decrease/'+rowId,
			type: 'GET',			
			success: function(res) {
				toastr['success']('Update quantity successfull!');
				row.remove();
				// alert(res);
				$('#tblCart-total').text(res.total);
				$('#tblCart-tax').text(res.tax);
				$('#tblCart').prepend('<tr id="row-'+res.item['rowId']+'"><td class="text-center">'+res.item['id']+'</td><td class="text-center"><img src="http://ashoes.com/'+res.item['thumbnail']+'" alt="'+res.item['name']+'" style="height: 80px"></td><td>'+res.item['name']+'</td><td>'+res.item['brand']+'</td><td>'+res.item['category']+'</td><td class="text-center"><a style="background-color:'+res.item['color']+'; border:1px solid grey; width: 15px; height: 15px" class="btn"></a></td><td class="text-center">'+res.item['size']+'</td><td class="text-center"><a class="btn btn-danger btn-sm btnDecrease" data-id="'+res.item['rowId']+'"><i class="fa fa-minus"></i></a>&nbsp;'+res.item['qty']+'&nbsp;<a class="btn btn-success btn-sm btnIncrease" data-id="'+res.item['rowId']+'"><i class="fa fa-plus"></i></a></td><td class="text-right">'+res.item['price']+'</td><td class="text-right">'+res.item['qty']*res.item['price']+'</td></tr>');
				
			},
			error: function(xhr, ajaxOptions, thrownError) {
				toastr['error']('Update quantity failed!');
			}
		})
	});
</script>
@endsection