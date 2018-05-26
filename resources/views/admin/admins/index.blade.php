@extends('admin.layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('admin_assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('current_page')
Admin
@endsection

@section('current_catalog')
User
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Table of Admin</h3>
					<a class="btn btn-primary fas fa-plus " data-toggle="modal" id='btnAdd' style="float: right">&nbsp;<i class="fas fa-bars"></i></a>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table table-hover table-bordered" id="tblAdmin">
						<thead>
							<tr>
								<th width="5%" class="text-center">ID</th>
								<th class="text-center" >Avatar</th>
								<th class="text-center" >Name</th>
								<th class="text-center" >Email</th>
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


{{-- modal Add --}}
<div class="modal fade" id="modalAdd">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add new Admin</h4>
			</div>
			<div class="modal-body">
				<form action="" method="POST" role="form" id="formAdd" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" id="name" placeholder="Name" name="name">
					</div>	
					<div class="form-group">
						<label for="">Email</label>
						<input type="email" class="form-control" id="email" placeholder="Email" name="email">
					</div>
					<div class="form-group">
						<label for="">Phone</label>
						<input class="form-control" id="phone" placeholder="Phone" name="phone">
					</div>
					<div class="form-group">
						<label for="">Birthday</label>
						<input class="form-control" id="birthday" name="birthday" type="date">
					</div>
					<div class="form-group">
						<label for="">Avatar</label>
						<div class="input-group">
							{{-- <span class="input-group-btn">
								<a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
									<i class="fa fa-picture-o"></i> Choose
								</a>
							</span>
							<input id="thumbnail" class="form-control" type="text" name="filepath"> --}}
							<span class="input-group-btn">
								<a id="lfm" data-input="thumbnail" data-preview="previewimg" class="btn btn-primary">
									<input type="file" name="thumbnail" id="thumbnail">
								</a>
							</span>
							{{-- <input id="thumbnail" class="form-control" type="file" name="images" multiple> --}}
						</div>
						<img id="holder" style="margin-top:15px;max-height:100px;">
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

{{-- modal Show --}}
<div class="modal fade" id="modalShow">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><b>Admin's information: <span id="show-id"></span></b></h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover">
					<tbody>
						<tr>
							<th width="25%">
								<img src="" alt="" id="show-avatar" height="80px">
							</th>
							<td id="show-name"></td>
						</tr>
						<tr>
							<th width="25%">Birthday</th>
							<td id="show-birthday"></td>
						</tr>
						<tr>
							<th width="25%">Email</th>
							<td id="show-email"></td>
						</tr>
						<tr>
							<th width="25%">Mobile</th>
							<td id="show-mobile"></td>
						</tr>
						<tr>
							<th width="25%">Created at</th>
							<td id="show-created-at"></td>
						</tr>
						<tr>
							<th width="25%">Lastest updated</th>
							<td id="show-lastest-updated"></td>
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
@endsection


@section('js')
<script src="{{ asset('admin_assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/laravel-filemanager/js/lfm.js') }}"></script>
<script>
	// $('#lfm').filemanager('file');
</script>
<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(function() {
		$('#tblAdmin').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{!! route('admin.admin.dataTable') !!}',
			columns: [
			{ data: 'id', name: 'id' },
			{ data: 'avatar', name: 'avatar', render: function(data, type, full, meta){
				return '<img src=\"http://ashoes.com/'+data+'" alt="" height="80px">' }
			},
			{ data: 'name', name: 'name' },
			{ data: 'email', name: 'email' },
			{ data: 'created_at', name: 'created_at' },
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

		var thumbnail = $('#thumbnail').get(0).files[0];
		var newAdmin = new FormData();

		newAdmin.append('name',$('#name').val());
		newAdmin.append('email',$('#email').val());
		newAdmin.append('thumbnail',thumbnail);
		newAdmin.append('phone',$('#phone').val());
		newAdmin.append('birthday',$('#birthday').val());

		$.ajax({
			url: '{{ route('admin.admin.store') }}',
			type: 'POST',
			processData: false,
			contentType: false,
			cache: false,
			dataType: 'JSON',
			data: newAdmin,
			success: function(res){
				$('#modalAdd').modal('hide');
				toastr['success']('Add new Admin successfully!');
				$('#tblAdmin').prepend('<tr id="'+res.id+'"><td width="5%" class="text-center">'+res.id+'</td><td class="text-center"><img src=\"http://ashoes.com/'+res.avatar+'" alt="" height="80px"></td><td>'+res.name+'</td><td class="text-center" >'+res.email+'</td><td>'+res.created_at+'</td><td class="text-center" width="15%" ><a title="Detail" class="btn btn-info btn-sm glyphicon glyphicon-eye-open btnShow" data-id="'+res.id+'" id="row-'+res.id+'"></a>&nbsp;<a title="Update" class="btn btn-warning btn-sm glyphicon glyphicon-edit btnEdit" data-id='+res.id+'></a>&nbsp;<a title="Delete" class="btn btn-danger btn-sm glyphicon glyphicon-trash btnDelete" data-id='+res.id+'></a></td></tr>');
				
			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr['error']('Add failed');
			}
		})		
	});

	$('#tblAdmin').on('click', '.btnDelete', function(event) {
		event.preventDefault();
		var id = $(this).data('id');
		swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover this Admin!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: '{{ asset('') }}admin/admins/delete/'+id,
					type: 'DELETE',
					success: function(res) {
						var row = document.getElementById(id);
						row.remove();
						swal({
							title: "The admin has been deleted!",
							icon: "success",
						});
					},
					error: function(xhr, ajaxOptions, thrownError) {
						toastr.error(thrownError)
					}
				})
				
			} else {
				swal({
					title: "The admin is safety!",
					icon: "success",
					button: "OK!",
				});
			}
		});
	});

	$('#tblAdmin').on('click', '.btnShow', function(event) {
		event.preventDefault();
		/* Act on the event */
		var id = $(this).data('id');
		$.ajax({
			url: '{{ asset('') }}admin/admins/show/'+id,
			type: 'GET',
			success: function(res){
				$('#modalShow').modal('show');
				$('#show-id').text(res.id);
				$('#show-name').text(res.name);
				$('#show-avatar').attr('src', 'http://ashoes.com/'+res.avatar);
				$('#show-birthday').text(res.birthday);
				$('#show-email').text(res.email);
				$('#show-mobile').text(res.phone);
				$('#show-created-at').text(res.created_at);
				$('#show-lastest-updated').text(res.updated_at);
			},
			error: function(xhr, ajaxOptions, thrownError){
				toastr.error(thrownError);
			}
		})		
	});

</script>
@endsection

