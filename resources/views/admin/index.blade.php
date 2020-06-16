@extends('layouts.master')

@section('content')
<div class="container py-5">
	<div class="card">
		<div class="card-body">
			<!-- @if(session('success'))
			<div class="alert alert-success">{{ session('success') }}</div>
			@endif -->
			<h3>Data Blog</h3>
			<hr>
			<div class="row mb-5">
				<div class="col-md-8">
					<a href="{{ url('admin/create') }}" class="btn btn-success">Buat Blog</a>
					<a href="{{ url('admin/export') }}" class="btn btn-primary ml-2">Export</a>
				</div>
				<div class="col-md-4 text-right">
					<form method="GET">
						<input type="text" name="search" class="form-control" placeholder="Cari Blog..." value="{{ $search }}">
					</form>
				</div>
			</div>
			<div>
			</div>
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Judul</th>
						<th scope="col">Kontent</th>
						<th scope="col">Kategori</th>
						<th scope="col">Penulis</th>
						<th scope="col">Gambar</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
					@if(count($blogs) == 0)
					<tr>
						<td colspan="6" class="text-center">Belum Ada Blog</td>
					</tr>
					@else
					@foreach($blogs as $k => $v)
					<tr>
						<td>{{ (request()->has('page')) ? (request()->page-1)*$limit+$k+1 : $k+1 }}</td>
						<td>{{ $v->title }}</td>
						<td>{{ $v->content }}</td>
						<td>{!! ($v->category != null) ? '<span class="badge badge-success">'.$v->category->name.'</span>' : '<span class="badge badge-warning"><i>Tidak Berkategori</i></span>' !!}</td>
						<td>{{ $v->user->name }}</td>
						<td>
							@if($v->image == null)
							<img src="https://beritakota.co.id/wp-content/plugins/penci-portfolio//images/no-thumbnail.jpg" height="80">
							@else
							<a href="{{ asset('storage/'.$v->image) }}" target="_blank">
								<img src="{{ asset('storage/'.$v->image) }}" height="80">
							</a>
							@endif
						</td>
						<td>
							<a href="{{ url('admin/edit/'.$v->id) }}" class="btn btn-warning">edit</a>
							<a href="#" onclick="delete_blog({{ $v->id }})" class="btn btn-danger">hapus</a>
						</td>
					</tr>
					@endforeach
					@endif
				</tbody>
			</table>
			<hr>
			{{ $blogs->links() }}
		</div>
	</div>	
</div>

<form method="post" id="form-delete" style="display: none;">
	@csrf
	<input type="hidden" name="_method" value="DELETE">
</form>

<script type="text/javascript">
	function delete_blog(id){
		if(confirm("Yakin ingin menghapus blog ?")){
			$("#form-delete").attr('action', '{{ url("admin/delete/") }}'+"/"+id);
			$("#form-delete").submit();
		}
	}
</script>

@endsection