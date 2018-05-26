@extends('admin.layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('admin_assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<style>
#modalShow{
	padding-top: 50px;
}
</style>
@endsection

@section('current_page')
Sizes
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
					<h3 class="box-title">Table of Size</h3>
					<a class="btn btn-primary fas fa-plus " data-toggle="modal" id='btnAdd' style="float: right">&nbsp;<i class="fas fa-bars"></i></a>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table table-hover table-bordered" id="tblSize">
						<thead>
							<tr>
								<th width="5%" class="text-center">ID</th>
								<th class="text-center" width="20%">Size</th>
								<th class="text-center" width="25%">Created at</th>
								<th class="text-center" width="25%">Updated at</th>
								<th class="text-center" width="25%">Action</th>
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


{{-- modal Add --}}
<div class="modal fade" id="modalAdd">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add new Size</h4>
			</div>
			<div class="modal-body">
				<form action="" method="POST" role="form" id="formAdd">
					@csrf
					<div class="form-group">
						<label for="">Size</label>
						<input type="number" class="form-control" id="size" placeholder="0" name="size" step="0.01" min="0" max="100">
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

{{-- modal Edit --}}
<div class="modal fade" id="modalEdit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><b>Edit Size</b></h4>
			</div>
			<div class="modal-body">
				<form action="" role="form" id="formEdit">
					<input type="hidden" name="_method" value="PUT">
					@csrf
					<input type="hidden" name="edit-id" id="edit-id">
					<div class="form-group">
						<label for="">Size</label>
						<input type="number" class="form-control" id="edit-size" name="edit-size" step="0.5" min="0" max="100">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Update</button>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>

{{-- modal Show --}}
<div class="modal fade" id="modalShow">
	<div class="container">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><b>List Product has size: <span id="show-size"></span></b></h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover table-bordered" id="tblProductBySize">
					<thead>
						<tr>
							<th width="5%" class="text-center">#</th>
							<th class="text-center" >Name</th>
							<th class="text-center" >Thumbnail</th>
							<th class="text-center" >Brand</th>
							<th class="text-center" >Category</th>
							<th class="text-center" >Action</th>
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
		$('#tblSize').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{!! route('admin.size.dataTable') !!}',
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'size', name: 'size' },
			{ data: 'created_at', name: 'created_at' },
			{ data: 'updated_at', name: 'updated_at' },
			{ data: 'action', name: 'action', orderable: false, searchable: false}
			]
		});
	});

	$('#btnAdd').on('click', function(event) {
		event.preventDefault();
		$('#modalAdd').modal('show');
	});

	$('#formAdd').on('submit', function(event) {
		event.preventDefault();
		$.ajax({
			url: '{{ route('admin.size.store') }}',
			type: 'POST',
			data: {
				size: $('#size').val(),
			},
			success: function(res){
				$('#modalAdd').modal('hide');
				toastr['success']('Add new Size successfully!');
				$('#tblSize').prepend('<tr id="'+res.id+'"><td width="5%" class="text-center">'+res.id+'</td><td class="text-center">'+res.size+'</td><td class="text-center">'+res.created_at+'</td><td>'+res.updated_at+'</td><td class="text-center" width="25%" ><a title="Detail" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'+res.id+'" id="row-'+res.id+'"></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='+res.id+'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='+res.id+'></a></td></tr>');
				
			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr['error']('Add failed');
			}
		})		
	});

	$('#tblSize').on('click', '.btnEdit', function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $(this).data('id');
		
		$.ajax({
			url: '{{ asset('') }}admin/sizes/edit/'+id,
			type: 'GET',
			success: function(res){
				$('#modalEdit').modal('show');
				$('#edit-size').val(res.size);
				$('#edit-id').attr('value',res.id);
			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr['error']('Can\'t display size to edit');
			}
		})
	});

	$('#formEdit').on('submit',function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $('#edit-id').val();
		$.ajax({
			url: '{{ asset('') }}admin/sizes/update/'+id,
			type: 'PUT',
			data: {
				size: $('#edit-size').val(),
			},
			success: function(res) {
				$('#modalEdit').modal('hide');
				var row = document.getElementById(id);
				row.remove();
				toastr['success']('Update the Size successfully!');
				$('#tblSize').prepend('<tr id="'+res.id+'"><td width="5%" class="text-center">'+res.id+'</td><td class="text-center">'+res.size+'</td><td class="text-center">'+res.created_at+'</td><td>'+res.updated_at+'</td><td class="text-center" width="15%" ><a title="Detail" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'+res.id+'" id="row-'+res.id+'"></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='+res.id+'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='+res.id+'></a></td></tr>');
				
			},
			error: function(xhr, ajaxOptions, thrownError) {
				toastr['error']('Update size failed!');
			}
		})
	});

	$('#tblSize').on('click', '.btnDelete', function(event) {
		event.preventDefault();
		var id = $(this).data('id');
		swal({
			title: "Are you sure?",
			text: "Once deleted, you will delete ALL PRODUCT has this size",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: '{{ asset('') }}admin/sizes/delete/'+id,
					type: 'DELETE',
					success: function(res) {
						var row = document.getElementById(id);
						row.remove();
						swal({
							title: "The size has been deleted!",
							icon: "success",
						});
					},
					error: function(xhr, ajaxOptions, thrownError) {
						toastr.error(thrownError)
					}
				})
				
			} else {
				swal({
					title: "The size is safety!",
					icon: "success",
					button: "OK!",
				});
			}
		});
	});

	$('#tblSize').on('click', '.btnShow', function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $(this).data('id');
		$('#modalShow').modal('show');
		$('#tblProductBySize').DataTable({
			processing: true,
			serverSide: true,
			destroy: true,
			ajax: '{{ asset('') }}admin/sizes/listProduct/'+id,
			columns: [
				{ data: 'id', name: 'id' },
				{ data: 'name', name: 'name' },
				{ data: 'thumbnail', name: 'thumbnail', render: function(data, type, full, meta){
					return '<img src=\"http://ashoes.com/'+data+'" alt="" height="80px">' }
				},
				{ data: 'brand', name: 'brand' },
				{ data: 'category', name: 'category' },
				{ data: 'action', name: 'action', orderable: false, searchable: false}
			]
		})
	});

</script>
@endsection

