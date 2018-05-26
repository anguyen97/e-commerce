@extends('admin.layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('admin_assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<link href="{{ asset('admin_assets/bower_components/SmartWizard-master/dist/css/smart_wizard.css') }}" rel="stylesheet" />
<style>
#modalAdd, #modalShow{
	padding: 15px ;
}
</style>
@endsection

@section('current_page')
All Products
@endsection

@section('current_catalog')
Product
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Table of Product</h3>
					<a class="btn btn-primary fas fa-plus btnAdd" id="btnAdd" style="float: right">&nbsp;<i class="fas fa-bars"></i></a>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table table-hover table-bordered" id="tblProduct">
						<thead>
							<tr>
								<th width="5%" class="text-center">#</th>
								<th class="text-center" >Name</th>
								<th class="text-center" >Thumbnail</th>
								<th class="text-center" >Brand</th>
								<th class="text-center" >Category</th>
								<th class="text-center" >Created at</th>
								<th class="text-center" >Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->	
</section>
<!-- /.content -->

{{-- modalAdd new product --}}
<div class="modal fade" id="modalAdd">
	<div class="container">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add new Product</h4>
			</div>
			<div class="modal-body">
				<form action="{{ route('admin.product.store') }}" method="POST" role="form" enctype="multipart/form-data" id="formAdd" name="formAdd">
					@csrf
					<div id="smartwizard">
						<ul>
							<li><a href="#step-1">Step 1<br /><small>General Information</small></a></li>
							<li><a href="#step-2">Step 2<br /><small>Details</small></a></li>
						</ul>

						<div>
							<div id="step-1" class="">
								<table class="table table-hover">
									<tbody>
										<tr>
											<td>
												<div class="form-group">
													<label for="">Name</label>
													<input type="text" class="form-control" id="name" placeholder="Name" name="name">
												</div>
											</td>
											<td>
												<div class="form-group">
													<div class="form-group">
														<label for="">Origin price</label>
														<input type="number" class="form-control" id="origin_price" placeholder="0" name="origin_price">
													</div>													
												</div>
											</td>
										</tr>
										<tr>
											<td>
												<label for="">Brand</label>
												<select name="brand" id="inputBrand" class="form-control" >
													@foreach ($brands as $brand)
													<option value="{{$brand['id']}}">{{$brand['name']}}</option>
													@endforeach													
												</select>
											</td>
											<td>
												<div class="form-group">
													<label for="">Sale price</label>
													<input type="number" class="form-control" id="sale_price" placeholder="0" name="sale_price">
												</div>
											</td>
										</tr>
										<tr>
											<td>
												<label for="">Category</label>
												<select name="category" id="inputCategory" class="form-control">
													@foreach ($categories as $category)
													<option value="{!!$category['id']!!}">{!!$category['name']!!}</option>
													@endforeach
													
												</select>
											</td>
											<td></td>
										</tr>
										<tr>									
											<td colspan="2">
												<div class="form-group">
													<label for="">Description</label>
													<textarea name="description" type="text" class="form-control" id="description" placeholder="Input field"></textarea>
												</div>
											</td>									
										</tr>								
										<tr>
											<td colspan="2">
												<div class="form-group">
													<label for="">Content</label>
													<textarea name="content" type="text" class="form-control" id="content" placeholder="Input field"></textarea>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<div class="form-group">
													<label for="">Image</label>
													<div class="input-group">
														{{-- <span class="input-group-btn">
															<a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
																<i class="fa fa-picture-o"></i> Choose
															</a>
														</span> --}}
														<input id="thumbnail" class="form-control" type="file" name="images[]" multiple>
													</div>
													<img id="holder" style="margin-top:15px;max-height:100px;">
												</div>
											</td>
										</tr>
									</tbody>

								</table>
							</div>
							<div id="step-2" class="">
								<table class="table table-hover" id="tblAddDetail">
									<thead>
										<tr>
											<th width="31%">Color</th>
											<th width="31%">Size</th>
											<th width="31%">Quantity</th>
											<th width="7%"></th>
										</tr>
									</thead>
									<tbody id="tbody">
										<tr class="detail" id="1" data-length='1'>
											<td>
												<input type="color" class="form-control" id="color-1" name="color-1" required>
											</td>
											<td>
												<input type="number" class="form-control" id="size-1" name="size-1" step="0.01" min="0" max="100" placeholder="0" required>
											</td>
											<td>
												<input type="number" class="form-control" id="quantity-1" name="quantity-1" placeholder="0" min="0" required>
											</td>
											<td>
												<a class="btn btn-info" id="btnAddDetail"><i class="fas fa-plus"></i></a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Create</button>
					</div>
					
				</form>
				
			</div>
			
		</div>
	</div>
</div>

{{-- modalShow product's information --}}
<div class="modal fade" id="modalShow">
	<div class="container">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">PRODUCT'S INFORMATION </h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover">
					<tbody>
						<tr>
							<td rowspan="5" >
								<img src="" alt="" id="show-thumbnail" width="50%">
							</td>
							<td width="15%">Product</td>
							<td id="show-name" width="35%"></td>
						</tr>
						<tr>
							<td>Brand</td>
							<td id="show-brand"></td>
						</tr>
						<tr>
							<td>Category</td>
							<td id="show-category"></td>
						</tr>
						<tr>
							<td>Price</td>
							<td id="show-price"></td>
						</tr>
						<tr>
							<td>Description</td>
							<td id="show-description"></td>
						</tr>
						<tr>
							<td id="show-content" colspan="3"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

{{-- modalShow Details --}}
<div class="modal fade" id="modalDetails">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">PRODUCT'S DETAILS</h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover table-bordered" id="tblProductDetails">
					<thead>
						<tr>
							<th width="5%" class="text-center">#</th>
							<th class="text-center">Name</th>
							<th class="text-center">Brand</th>
							<th class="text-center">Category</th>
							<th class="text-center">Color</th>
							<th class="text-center">Size</th>
							<th class="text-center">Quantity</th>
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
</div>


@endsection


@section('js')
<script src="{{ asset('admin_assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('admin_assets/bower_components/SmartWizard-master/dist/js/jquery.smartWizard.min.js') }}"></script>
<script>
	$(document).ready(function(){
		$('#smartwizard').smartWizard();
	});
</script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/laravel-filemanager/js/lfm.js') }}"></script>

<script>
	var options = {
		filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
		filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
		filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
		filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
	};
	CKEDITOR.replace( 'content', options );
</script>

<script>
	$('#lfm').filemanager('image');
</script>

<script>
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(function() {
		$('#tblProduct').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{!! route('admin.product.dataTable') !!}',
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'name', name: 'name' },
			{ data: 'thumbnail', name: 'thumbnail', render: function(data, type, full, meta){
				return '<img src=\"http://ashoes.com/'+data+'" alt="" height="80px">' }
			},
			{ data: 'brand', name: 'brand' },
			{ data: 'category', name: 'category' },
			{ data: 'created_at', name: 'created_at' },
			{ data: 'action', name: 'action', orderable: false, searchable: false}
			]
		});
	});

	$('#btnAdd').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		$('#modalAdd').modal('show');
	});

	var i= 1; //chỉ số để thêm chi tiết sản phẩm khi thêm sản phẩm mới

	$(function() {

		$('#tblAddDetail').on('click','#btnAddDetail' ,function(event) {
			event.preventDefault();
			var row = document.getElementsByClassName('detail');
			// var length = $('#tbody #1').data('length');
			var length = ++i;
			$('#tbody #1').attr('data-length', length);
			console.log(length);

			$('#tblAddDetail').append('<tr class="detail" id="'+length+'"><td><input type="color" class="form-control" id="color-'+length+'" name="color-'+length+'" required></td><td><input type="number" class="form-control" id="size-'+length+'" name="size-'+length+'" step="0.01" min="0" max="100" required></td><td><input type="number" class="form-control" id="quantity-'+length+'" name="quantity-'+length+'" placeholder="0" required></td><td><a class="btn btn-info btnRemoveDetail" id="btnRemoveDetail" data-row="'+length+'"><i class="fas fa-minus"></i></a></td></tr>');
		});

		$('#tblAddDetail').on('click', '.btnRemoveDetail', function(event) {
			event.preventDefault();
			var row_id = $(this).data('row');
			console.log(row);
			var row = document.getElementById(row_id);
			row.remove();
		});
	});	

	$('#tblProduct').on('click', '.btnShow', function(event) {

		event.preventDefault();
		$('#modalShow').modal('show');
		var product_id = $(this).data('id');
		$.ajax({
			url: '{{ asset('') }}admin/products/show/'+product_id,
			type: 'GET',
			success: function(res) {
				$('#show-name').text(res.name);
				$('#btnMoreInfor').attr('data-id', res.id);
				$('#show-brand').text(res.brand);
				$('#show-category').text(res.category);
				$('#show-price').text(res.sale_price+' $/ '+res.origin_price +' $');
				$('#show-description').text(res.description);
				$('#show-content').text(res.content);
				$('#show-thumbnail').attr('src', 'http://ashoes.com/'+res.thumbnail);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				toastr['error']('Load this product failed!');
			}
		})
	});


	$('#tblProduct').on('click', '.btnList', function(event) {
		event.preventDefault();
		var id = $(this).data('id');

		$('#modalDetails').modal('show');
		$('#tblProductDetails').DataTable({
			processing: true,
			serverSide: true,
			destroy: true,
			ajax: '{{ asset('') }}admin/products/details/'+id,
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'name', name: 'name' },
			{ data: 'brand', name: 'brand' },
			{ data: 'category', name: 'category' },
			{ data: 'code', name: 'code', render: function(row, data, index){
				return $('td', row).eq(4).css('bgcolor', data);}
			},
			{ data: 'size', name: 'size' },
			{ data: 'quantity', name: 'quantity' },
			]
		})
	});	

	$('#tblProduct').on('click', '.btnDelete', function(event) {
		event.preventDefault();
		var id = $(this).data('id');
		swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover this Product!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: '{{ asset('') }}admin/products/delete/'+id,
					type: 'DELETE',
					success: function(res) {
						var row = document.getElementById(id);
						row.remove();
						swal({
							title: "The product has been deleted!",
							icon: "success",
						});
					},
					error: function(xhr, ajaxOptions, thrownError) {
						toastr.error(thrownError);
					}
				})
				
			} else {
				swal({
					title: "The product is safety!",
					icon: "success",
					button: "OK!",
				});
			}
		});
	});	

</script>

@endsection

