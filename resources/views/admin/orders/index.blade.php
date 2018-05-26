@extends('admin.layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('admin_assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('current_page')
Orders
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
					<h3 class="box-title">Table of Order</h3>
					<a class="btn btn-primary fas fa-plus " data-toggle="modal" id='btnAdd' style="float: right">&nbsp;<i class="fas fa-bars"></i></a>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table table-hover table-bordered" id="tblOrder">
						<thead>
							<tr>
								<th width="5%" class="text-center">ID</th>
								<th class="text-center" >Name</th>
								<th class="text-center" >Address</th>
								<th class="text-center" >Mobile</th>
								<th class="text-center" >Total</th>
								<th class="text-center" >Status</th>
								<th class="text-center" width="15%">Created at</th>
								<th class="text-center" width="15%">Action</th>
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


{{-- modal Edit --}}
{{-- <div class="modal fade" id="modalEdit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><b>Edit Order</b></h4>
			</div>
			<div class="modal-body">
				<form action="" role="form" id="formEdit">
					<input type="hidden" name="_method" value="PUT">
					@csrf
					<input type="hidden" name="edit-id" id="edit-id">
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" id="edit-name" name="edit-name">
					</div>
					<div class="form-group">
						<label for="">Country</label>
						<input type="text" class="form-control" id="edit-country" name="edit-country">
					</div>
					<div class="form-group">
						<label for="">Description</label>
						<textarea type="text" class="form-control" id="edit-description" name="edit-description"></textarea>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Update</button>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div> --}}

{{-- modal Show --}}
<div class="modal fade" id="modalShow">
	<div class="container">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><b>Order's information: <span id="show-id"></span></b></h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover table-bordered" id="tblOrderDetails">
					<thead>
						<tr>
							<th width="5%" class="text-center">#</th>
							<th class="text-center" >Name</th>
							<th class="text-center" >Thumbnail</th>
							<th class="text-center" >Brand</th>
							<th class="text-center" >Category</th>
							<th class="text-center" >Color</th>
							<th class="text-center" >Size</th>
							<th class="text-center" >Quantity</th>
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
<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(function() {
		$('#tblOrder').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{!! route('admin.order.dataTable') !!}',
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'name', name: 'name' },
			{ data: 'address', name: 'address' },
			{ data: 'mobile', name: 'mobile' },
			{ data: 'total_price', name: 'total_price' },
			{ data: 'status', name: 'status' },
			{ data: 'created_at', name: 'created_at' },
			{ data: 'action', name: 'action', orderable: false, searchable: false}
			]
		});
	});


	$('#tblOrder').on('click', '.btnEdit', function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $(this).data('id');
		
		$.ajax({
			url: '{{ asset('') }}admin/orders/edit/'+id,
			type: 'GET',
			success: function(res){
				$('#modalEdit').modal('show');
				$('#edit-name').attr('value',res.name);
				$('#edit-country').attr('value',res.country);
				$('#edit-description').text(res.description);
				$('#edit-id').attr('value',res.id);
			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr['error']('Can\'t display Order to edit');
			}
		})
	});

	$('#formEdit').on('submit',function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $('#edit-id').val();
		$.ajax({
			url: '{{ asset('') }}admin/orders/update/'+id,
			type: 'PUT',
			data: {
				name: $('#edit-name').val(),
				description: $('#edit-description').val(),
				country: $('#edit-country').val(),
			},
			success: function(res) {
				$('#modalEdit').modal('hide');
				var row = document.getElementById(id);
				row.remove();
				toastr['success']('Update the Order successfully!');
				$('#tblOrder').prepend('<tr id="'+res.id+'"><td width="5%" class="text-center">'+res.id+'</td><td class="text-center">'+res.name+'</td><td class="text-center" >'+res.country+'</td><td class="text-center">'+res.description+'</td><td>'+res.created_at+'</td><td class="text-center" width="15%" ><a title="Detail" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'+res.id+'" id="row-'+res.id+'"></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='+res.id+'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='+res.id+'></a></td></tr>');
				
			},
			error: function(xhr, ajaxOptions, thrownError) {
				toastr['error']('Update Order failed!');
			}
		})
	});

	$('#tblOrder').on('click', '.btnDelete', function(event) {
		event.preventDefault();
		var id = $(this).data('id');
		swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover this Order!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: '{{ asset('') }}admin/orders/delete/'+id,
					type: 'DELETE',
					success: function(res) {
						var row = document.getElementById(id);
						row.remove();
						swal({
							title: "The Order has been deleted!",
							icon: "success",
						});
					},
					error: function(xhr, ajaxOptions, thrownError) {
						toastr.error(thrownError)
					}
				})
				
			} else {
				swal({
					title: "The Order is safety!",
					icon: "success",
					button: "OK!",
				});
			}
		});
	});

	

	$('#tblOrder').on('click', '.btnShow', function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $(this).data('id');

		$('#modalShow').modal('show');
		$('#tblOrderDetails').DataTable({
			processing: true,
			serverSide: true,
			destroy: true,
			ajax: '{{ asset('') }}admin/orders/listProduct/'+id,
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'name', name: 'name' },
			{ data: 'thumbnail', name: 'thumbnail', render: function(data, type, full, meta){
				return '<img src=\"http://ashoes.com/'+data+'" alt="" height="80px">' }
			},
			{ data: 'brand', name: 'brand' },
			{ data: 'category', name: 'category' },
			{ data: 'color', name: 'color' },
			{ data: 'size', name: 'size' },
			{ data: 'quantity', name: 'quantity' },
			]
		})
	});
	



	// $.ajax({
	// 	url: 'admin/orders/show/'+id,
	// 	type: 'GET',
	// 	success: function(res){
	// 		$('#modalShow').modal('show');
	// 		$('#show-id').text(res.id);
	// 		$('#show-name').text(res.name);
	// 		$('#show-country').text(res.country);
	// 		$('#show-description').text(res.description);
	// 		$('#show-created-at').text(res.created_at);
	// 		$('#show-lastest-updated').text(res.updated_at);
	// 	},
	// 	error: function(xhr, ajaxOptions, thrownError){
	// 		toastr.error(thrownError);
	// 	}
	// })	
</script>
@endsection

