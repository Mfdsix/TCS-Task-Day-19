@extends('layouts.master')

@section('content')
<div class="container py-5">
	<div class="card">
		<div class="card-body">
			<!-- @if(session('success'))
			<div class="alert alert-success">{{ session('success') }}</div>
			@endif -->
			<h3>Blog Terbaru</h3>
			<hr>
			<div class="row mb-5">
				<div class="col-md-8">
				</div>
				<div class="col-md-4 text-right">
					<form method="GET">
						<input type="text" name="search" class="form-control" placeholder="Cari Blog..." value="{{ $search }}">
					</form>
				</div>
			</div>
			<div>
			</div>
			<div class="row">
				@if(count($blogs) == 0)
				<div class="col-md-12 mb-4">
					<h3 class="text-center">Belum Ada Blog</h3>
				</div>
				@else
				@foreach($blogs as $k => $v)
				<div class="col-md-4 mb-4">
					<div class="card">
						@if($v->image != null)
						<img class="card-img-top" style="height: 200px;object-fit: cover;" src="{{ asset('storage/'.$v->image) }}" alt="Card image cap">
						@else
						<img class="card-img-top" style="height: 200px;object-fit: cover;" src="https://beritakota.co.id/wp-content/plugins/penci-portfolio//images/no-thumbnail.jpg" alt="Card image cap">
						@endif
						<div class="card-body">
							<h5 class="card-title">{{ $v->title }}</h5>
							<u class="text-primary">{!! ($v->category != null) ? '<span class="badge badge-primary">'.$v->category->name.'</span>' : '<span class="badge badge-warning"><i>Tidak Berkategori</i></span>' !!}</u>
							<p class="card-text">{{ substr($v->content, 0, 60) }}...</p>
							<a href="{{ url('blog/'.$v->id) }}" class="btn btn-warning">Lihat Detail</a>
						</div>
					</div>
				</div>
				@endforeach
				@endif
			</div>
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